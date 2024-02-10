# PHP Project Template

A complete PHP project template. To use this template you will need to have:

- [Docker](https://www.docker.com/) version 25.0.3 or greater.

<ul>
    <li><a href="#setting-up">Setting up your data</a></li>
    <li><a href="#starting-new-project">Starting a new Project</a></li>
    <li>
        <a href="#files-folder">Files and Folder</a>
        <ul>
            <li><a href="#bin-folder">The bin foler</a></li>
            <li><a href="#config-folder">The config foler</a></li>
            <li><a href="#public-folder">The public foler</a></li>
        </ul>
    </li>
</ul>

<h2 id="setting-up">Setting your data</h2>

To start a new app with this template let's make some modifications:
1. On **docker-compose.yml**:
   - Change the **<database_name>** template to your database name (This database is only for development, when your project is done, connect to a real database).
   - Change the **appname** to your application name.
   - Change the **<image_name>>** to your project's docker image (where are going to build an image for the project later).
2. On **LICENSE**:
   - Change the **<app_creation_data>** to the date you created the app.
   - Change the **<app_author_name>** to your name.
3. On **composer.json**:
   - Change the **appname/appname** to yout application name.
   - Add a description on **description** JSON key.
   - In the **authors** JSON key, change the **name** and **role** to your respective name and role.

<h2 id="starting-new-project">Starting a new project</h2>

To start a new app let's build a new docker image:
```
docker build . -t appname/dev:1.0
```
Remember to change the **appname** to your actual application name. <br>
Now run docker compose to create a docker container to our app and database.
```
docker compose up -d
```

<h2 id="files-folder">Files and folder</h2>

Let's start by the beginning. <br>

<h3 id="bin-folder">The bin folder</h3>

The **bin** folder is meant to hold all the PHP scripts. For example, migrations to setup development database are a good case for scripts that should be inside the **bin** folder.


<h3 id="config-folder">The config folder</h3>

The **config** folder have the project configurations files. Inside this folder you will find the container configuration folder (`config/container`). <br>
You will also find the application configuration files inside the `config/app` folder. Files that hold the avaliable HTTP request to the app, flash message types and session keys, etc.

<h3 id="public-folder">The public folder</h3>

// TODO: finish the public folder documentation
