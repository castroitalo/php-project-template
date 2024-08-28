<?php

declare(strict_types=1);

namespace App\Core\Database;

use App\Core\Enums\ExceptionCodes\DatabaseExceptionCodes\HandlerExceptionCodesEnum;
use App\Core\Exceptions\Database\HandlerException;
use PDO;
use PDOException;

/**
 * Handle data inside the database
 *
 * @package App\Core\Database
 */
final class Handler
{
    /**
     * Handler database connection
     *
     * @var null|PDO
     */
    private ?PDO $databaseConnection = null;

    /**
     * Initialize database handler
     *
     * @param string $databaseName Database name for connection
     * @param string $databaseHost Database host for connection
     * @param string $databasePort Database port for connection
     * @param string $databaseUser Database user for connection
     * @param string $databasePassword Database password for connection
     * @param array $connectionAttributes Connection attributes
     * @return void
     */
    public function __construct(
        string $databaseName,
        string $databaseHost,
        string $databasePort,
        string $databaseUser,
        string $databasePassword,
        array $connectionAttributes,
        private int $failedInsertionExceptionCode = HandlerExceptionCodesEnum::FailedInsertion->value,
        private int $failedSelectExceptionCode    = HandlerExceptionCodesEnum::FailedSelect->value,
        private int $failedUpdateExceptionCode    = HandlerExceptionCodesEnum::FailedUpdate->value,
        private int $failedDeleteExceptionCode    = HandlerExceptionCodesEnum::FailedDelete->value
    ) {
        $this->databaseConnection = Connection::getInstance()->getConnection(
            $databaseName,
            $databaseHost,
            $databasePort,
            $databaseUser,
            $databasePassword,
            $connectionAttributes
        );
    }

    /**
     * Insert new data into a database table
     *
     * @param string $tableName Database table name to insert a new data
     * @param array $tableColumns Database table columns
     * @param array $newData New register data
     * @return int
     * @throws HandlerException
     */
    public function insert(string $tableName, array $tableColumns, array $newData): int
    {
        // Check if the `tableColumsn` has the same index for `newData`
        if (count($tableColumns) !== count($newData)) {
            throw new HandlerException(
                'Every column must have an equivalent value with it.',
                $this->failedInsertionExceptionCode
            );
        }

        try {
            $sqlTempalte = 'INSERT INTO {:table_name} ({:columns}) VALUES ({:values});';
            $columns     = implode(', ', $tableColumns);
            $values      = ':' . implode(', :', $tableColumns);
            $sql         = str_replace(['{:table_name}', '{:columns}', '{:values}'], [$tableName, $columns, $values], $sqlTempalte);
            $stmt        = $this->databaseConnection->prepare($sql);

            $stmt->execute(array_combine($tableColumns, $newData));

            return (int)$this->databaseConnection->lastInsertId();
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            throw new HandlerException(
                'Failed inserting data into ' . $tableName . ' table.',
                $this->failedInsertionExceptionCode,
                $ex
            );
        }
    }

    /**
     * Retrieve data from database
     *
     * @param string $queryTemplate Query template to execute
     * @param null|array $queryValues Query values for `$queryTempalte`
     * @return array
     * @throws HandlerException
     */
    public function get(string $queryTemplate, ?array $queryValues = null): array
    {
        try {
            $stmt = $this->databaseConnection->prepare($queryTemplate);

            if (!is_null($queryValues)) {
                // Check if every query template placeholder has a value
                preg_match_all('/:\w+/', $queryTemplate, $queryTemplatePlaceholders);

                if (count($queryTemplatePlaceholders[0]) !== count($queryValues)) {
                    throw new HandlerException(
                        'Every query placeholder must have it equivalent value.',
                        $this->failedSelectExceptionCode
                    );
                }

                for ($i = 0; $i < count($queryValues); ++$i) {
                    $placeholder = $queryTemplatePlaceholders[0][$i];
                    $value       = $queryValues[$i];
                    $valueType   = is_string($queryValues[$i]) ? PDO::PARAM_STR : PDO::PARAM_INT;

                    $stmt->bindValue($placeholder, $value, $valueType);
                }
            }

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            throw new HandlerException(
                $ex->getMessage(),
                $this->failedSelectExceptionCode,
                $ex
            );
        }
    }

    /**
     * Update an existent register on database
     *
     * @param string $tableName Database table name to be updated
     * @param array $updateSet Update set array with every array key being the column name
     * and every array value the column new value
     * @param string $whereTemplate Where template with PDO placeholders
     * @param string $whereTemplateValues Where template values in the format 'user_id=1&user_name="Felipe"'
     * so it can be parsed to an array
     * @return true
     */
    public function update(string $tableName, array $updateSet, string $whereTemplate, string $whereTemplateValues): true
    {
        try {
            $sqlTemplate       = 'UPDATE {:table_name} SET {:update_set} WHERE {:condition}';
            $updateSetTemplate = [];

            // Generate update set string from $updateSet array
            foreach ($updateSet as $key => $value) {
                $updateSetTemplate[] = $key . ' = :' . $key;
            }

            $updateSetTemplate = implode(', ', $updateSetTemplate);

            // Create SQL code and PDO statement for execution
            $sql  = str_replace(
                ['{:table_name}', '{:update_set}', '{:condition}'],
                [$tableName, $updateSetTemplate, $whereTemplate],
                $sqlTemplate
            );
            $stmt = $this->databaseConnection->prepare($sql);

            // Bind update set values to SQL code
            foreach ($updateSet as $key => $value) {
                $updateSetTemplateValueType = is_string($value) ? PDO::PARAM_STR : PDO::PARAM_INT;

                $stmt->bindValue(':' . $key, $value, $updateSetTemplateValueType);
            }

            parse_str($whereTemplateValues, $whereTemplateValuesArray);

            // Bind where template values
            foreach ($whereTemplateValuesArray as $key => $value) {
                $whereTemplateValueType = is_string($value) ? PDO::PARAM_STR : PDO::PARAM_INT;

                $stmt->bindValue(':' . $key, $value, $whereTemplateValueType);
            }

            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            throw new HandlerException(
                'Failed updating ' . $tableName . ' table data.',
                $this->failedUpdateExceptionCode,
                $ex
            );
        }
    }

    /**
     * Delete a data from database
     *
     * @param string $tableName Database table name to be deleted
     * @param string $whereTemplate Where condition template with PDO placeholders
     * @param string $whereTemplateValues Where condition template placeholders values
     * @return bool
     */
    public function delete(string $tableName, string $whereTemplate, string $whereTemplateValues): bool
    {
        try {
            // DELETE FROM table_name WHERE condition
            $sqlTempalte = 'DELETE FROM {:table_name} WHERE {:condition}';
            $sql         = str_replace(
                ['{:table_name}', '{:condition}'],
                [$tableName, $whereTemplate],
                $sqlTempalte
            );
            $stmt        = $this->databaseConnection->prepare($sql);

            parse_str($whereTemplateValues, $whereTemplateValuesArray);

            foreach ($whereTemplateValuesArray as $key => $value) {
                $whereTemplateValueType = is_string($value) ? PDO::PARAM_STR : PDO::PARAM_INT;

                $stmt->bindValue(':' . $key, $value, $whereTemplateValueType);
            }

            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            throw new HandlerException(
                'Failed delete data from ' . $tableName . ' table.',
                $this->failedDeleteExceptionCode,
                $ex
            );
        }
    }
}
