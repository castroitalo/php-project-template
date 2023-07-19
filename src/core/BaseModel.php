<?php

namespace src\core;

use src\core\DBConnection;

/**
 * Class BaseModel = Base class for models
 * @abstract 
 * @package src\core
 */
abstract class BaseModel
{

    /**
     * Current model data
     * @var \stdClass|null
     */
    protected ?\stdClass $data = null;

    /**
     * Current occurred exception
     * @var \Exception|null
     */
    protected ?\Exception $fail = null;

    /**
     * BaseModel setter
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, mixed $value): void
    {
        if (empty($this->data)) {
            $this->data = new \stdClass();
        }

        $this->data->$name = $value;
    }

    /**
     * BaseModel getter
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->data->$name;
    }

    /**
     * BaseModel is set
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->data->$name);
    }

    /**
     * Verify if all model's required fields are filled
     * @param array $requiredFields
     * @param object $data
     * @return bool
     */
    protected function checkRequiredFields(array $requiredFields, object $data): bool
    {
        foreach ($requiredFields as $requiredField) {
            if (!isset($data->$requiredField) || $this->data->$requiredField === "") {
                return false;
            }
        }

        return true;
    }

    /**
     * Unset model's safe columns
     * @param object $data
     * @param array $safeColumns
     * @return array|null
     */
    protected function unsetSafeColumns(object $data, array $safeColumns): ?array
    {
        $arrayData = ((array) $data ?? null);

        if (empty($safeColumns)) {
            return $arrayData;
        }

        foreach ($safeColumns as $safeColumn) {
            unset($arrayData[$safeColumn]);
        }

        return $arrayData;
    }

    /**
     * Filter malicious data in model data
     * @param array $data
     * @return array|null
     */
    protected function filterData(array $data): ?array
    {
        $filteredData = [];

        foreach ($data as $key => $value) {
            $filteredData[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $filteredData;
    }

    /**
     * Execute a INSERT statement in database for a child model
     * @param object $data
     * @param array $safeColumns
     * @param string $table
     * @return int|null
     */
    protected function createData(object $data, array $safeColumns, string $table): ?int
    {
        try {
            $filteredData = $this->filterData($this->unsetSafeColumns($data, $safeColumns));
            $columns = implode(", ", array_keys($filteredData));
            $values = ":" . implode(", :", array_keys($filteredData));
            $sql = "INSERT INTO {$table} 
                        ({$columns}) 
                    VALUES ({$values})";
            $stmt = DBConnection::getConnection()->prepare($sql);

            $stmt->execute($filteredData);

            return DBConnection::getConnection()->lastInsertId();
        } catch (\PDOException $ex) {
            $this->fail = $ex;

            return null;
        }
    }

    /**
     * Execute a SELECT statement in database based in a provided SQL script and parameters
     * @param string $table
     * @param string|null $terms
     * @param string|null $params
     * @param string $columns
     * @return \PDOStatement|null
     */
    protected function readData(
        string $table,
        ?string $terms = null,
        ?string $params = null,
        string $columns = "*"
    ): ?\PDOStatement {
        try {
            // SELECT <columns> FROM <table> <terms>
            $sql = "SELECT {$columns} 
                    FROM {$table}
                    {$terms}";
            $stmt = DBConnection::getConnection()->prepare($sql);

            if ($params) {
                parse_str($params, $arrParams);

                foreach ($arrParams as $paramKey => $paramValue) {
                    $paramType = (is_numeric($paramValue) ? \PDO::PARAM_INT : \PDO::PARAM_STR);

                    $stmt->bindValue(":{$paramKey}", $paramValue, $paramType);
                }
            }

            $stmt->execute();

            return $stmt;
        } catch (\PDOException $ex) {
            $this->fail = $ex;

            return null;
        }
    }

    /**
     * Execute an UPDATE statement in database for a child model
     * @param object $data
     * @param array $safeColumns
     * @param string $table
     * @param string $where
     * @return int|null
     */
    protected function updateData(object $data, array $safeColumns, string $table, string $where): ?int
    {
        try {
            $filteredData = $this->filterData($this->unsetSafeColumns($data, $safeColumns));
            $values = array_keys($filteredData);
            $setValues = "";
            $lastValue = end($values);

            foreach ($values as $value) {
                if ($value === $lastValue) {
                    $setValues .= "{$value}=:{$value}";

                    break;
                }

                $setValues .= "{$value}=:{$value}, ";
            }

            $sql = "UPDATE {$table} 
                    SET {$setValues} 
                    WHERE {$where}";
            $stmt = DBConnection::getConnection()->prepare($sql);

            $stmt->execute($filteredData);

            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $ex) {
            $this->fail = $ex;

            return null;
        }
    }

    /**
     * Delete a model data from database
     * @param string $table
     * @param string $where
     * @return int|null
     */
    protected function deleteData(string $table, string $where): ?int
    {
        try {
            $sql = "DELETE FROM {$table} 
                    WHERE {$where}";
            $stmt = DBConnection::getConnection()->prepare($sql);

            $stmt->execute();

            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $ex) {
            $this->fail = $ex;

            return null;
        }
    }

    /**
     * Get current data 
     * @return \stdClass|null
     */
    public function getData(): ?\stdClass
    {
        return $this->data;
    }

    /**
     * Return current fail
     * @return \Exception|null
     */
    public function getFail(): ?\Exception
    {
        return $this->fail;
    }
}
