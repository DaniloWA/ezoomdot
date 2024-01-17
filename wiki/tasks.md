# Tasks

<br/>

## Índice

### [Criando](#post-tasks)

### [Todos os dados](#get-tasks)

### [Pesquisa](#get-tasksuuid)

### [Atualizando](#put-tasksuuid)

### [Deletando](#del-tasksuuid)

### [EER](#diagrama-eer)

#### [Voltar pro Readme](/README.md)

---

<br/>
<br/>

## POST /tasks

```
  http://[SUA_URI]/api/v1/tasks
```

#### Header

```json
{
    "Authorization": "Bearer {{ token }}"
}
```

<br>

#### BODY

![Body store tasks](/img/body_store_tasks.png)

<details> 
  <summary>Code</summary>

```json
{
    "title": "Refactor database schema",
    "description": "Update the database schema to accommodate new changes in the application models.",
    "status": "pending",
    "priority": "medium",
    "deadline": "15-05-2025"
}
```

</details>

<br/>

#### Response Success 201

![Response](/img/response_success_store_tasks.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Success",
    "status_code": 201,
    "message": "Task created successfully",
    "data": {
        "title": "Refactor database schema",
        "description": "Update the database schema to accommodate new changes in the application models.",
        "status": "pending",
        "priority": "medium",
        "deadline": "15/05/2025",
        "uuid": "27e8a456-7ecf-4f12-bcb0-57900298d1ae",
        "slug": "refactor-database-schema-1",
        "updated_at": "17/01/2024",
        "created_at": "17/01/2024"
    }
}
```

</details>

<br/>

#### Response Error 422

![Response](/img/response_error_store_tasks.png)

<details> 
  <summary>Code</summary>

```json
{
    "message": "We need your [ TITLE ] to continue! (and 2 more errors)",
    "errors": {
        "title": ["We need your [ TITLE ] to continue!"],
        "priority": ["The selected priority is invalid."],
        "deadline": [
            "The deadline field must be a date after or equal to today."
        ]
    }
}
```

</details>

<br>

[Início](#tasks)

---

<br/>
<br/>

## GET /tasks

<br>

> Esta rota retorna uma lista paginada de tasks com base nos parâmetros fornecidos.

```
  GET /api/v1/tasks
```

> Ex com filtros

```
  GET /api/v1/tasks?per_page=10&page=1&status=completed&priority=high&user=1&deadline_start=2023-01-15&deadline_end=2023-01-20
```

| Headers         | value                  | Descrição                         |
| :-------------- | :--------------------- | :-------------------------------- |
| `Authorization` | `Bearer {{api_token}}` | **Obrigatório**. Token do usuário |

| params           | value                            | Descrição                                                                 |
| :--------------- | :------------------------------- | :------------------------------------------------------------------------ |
| `per_page`       | `int`                            | **Opcional**. Define a quantidade de tasks a serem exibidas por página    |
| `page`           | `int`                            | **Opcional**. Especifica a página desejada na listagem paginada           |
| `status`         | `str:pending,completed,canceled` | **Opcional**. Filtra tasks pelo status desejado (e.g., completed)         |
| `priority`       | `str:low,medium,high,critical`   | **Opcional**. Filtra tasks pela prioridade desejada (e.g., critical)      |
| `user`           | `uuid`                           | **Opcional**. FFiltra tasks pelo UUID do usuário associado                |
| `deadline_start` | `date:Y-m-d`                     | **Opcional**. Filtra tasks com prazo de início a partir da data fornecida |
| `deadline_end`   | `date:Y-m-d`                     | **Opcional**. Filtra tasks com prazo de término até a data fornecida      |

> **Observação**: Para que o filtro deadline_start e deadline_end funcione corretamente, ambas as datas devem ser fornecidas com valores válidos.

<br/>

#### Response Success 200

![Response](/img/response_success_tasks.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Success",
    "status_code": 200,
    "message": "Tasks retrieved successfully",
    "data": {
        "current_page": 1,
        "data": [
            {
                "uuid": "a6628e95-55dd-4d6e-ad6c-7b21558d89be",
                "title": "In dolores quisquam assumenda totam.",
                "slug": "in-dolores-quisquam-assumenda-totam",
                "description": "Perferendis rem eaque minus nisi. Illum aspernatur adipisci consequatur ut blanditiis non et iure. Soluta nulla alias ea fugiat velit possimus voluptas.",
                "status": "completed",
                "priority": "high",
                "deadline": "19/01/2024",
                "created_at": "16/01/2024",
                "updated_at": "16/01/2024",
                "deleted_at": null
            }
        ],
        "first_page_url": "http://localhost:8000/api/v1/tasks?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8000/api/v1/tasks?page=1",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost:8000/api/v1/tasks?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": null,
        "path": "http://localhost:8000/api/v1/tasks",
        "per_page": 10,
        "prev_page_url": null,
        "to": 8,
        "total": 8
    }
}
```

</details>

<br/>

## GET /tasks/{{uuid}}

```
  http://[SUA_URI]/api/v1/tasks/{{uuid}}
```

#### Header

```json
{
    "Authorization": "Bearer {{ token }}"
}
```

<br/>

#### Response Success 200

![Response](/img/response_success_show_tasks.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Success",
    "status_code": 200,
    "message": "Task retrieved successfully",
    "data": {
        "uuid": "27e8a456-7ecf-4f12-bcb0-57900298d1ae",
        "title": "Refactor database schema",
        "slug": "refactor-database-schema-1",
        "description": "Update the database schema to accommodate new changes in the application models.",
        "status": "pending",
        "priority": "medium",
        "deadline": "15/05/2025",
        "created_at": "17/01/2024",
        "updated_at": "17/01/2024",
        "deleted_at": null,
        "user": {
            "uuid": "2016cca7-c155-48b4-bb2b-762f5838d4a5",
            "name": "UserTeste",
            "email": "User@gmail.com"
        }
    }
}
```

</details>

<br/>

#### Response Error 404

![Response](/img/response_error_generic_404.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Error",
    "status_code": 404,
    "message": "The searched resource does not exist",
    "data": []
}
```

</details>

<br>

[Início](#tasks)

---

<br/>
<br/>

## PUT /tasks/{{uuid}}

```
  http://[SUA_URI]/api/v1/tasks/{{uuid}}
```

#### Header

```json
{
    "Authorization": "Bearer {{ token }}"
}
```

<br/>

#### BODY

![Body put tasks](/img/body_put_tasks.png)

<details> 
  <summary>Code</summary>

```json
{
    "title": "Implement new feature",
    "description": "Develop the new user authentication feature.",
    "status": "pending",
    "priority": "high",
    "deadline": "2025-04-30"
}
```

</details>

<br/>

#### Response Success 200

![Response](/img/response_success_put_tasks.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Success",
    "status_code": 200,
    "message": "Task updated successfully",
    "data": {
        "uuid": "27e8a456-7ecf-4f12-bcb0-57900298d1ae",
        "title": "Implement new feature",
        "slug": "implement-new-feature",
        "description": "Develop the new user authentication feature.",
        "status": "pending",
        "priority": "high",
        "deadline": "30/04/2025",
        "created_at": "17/01/2024",
        "updated_at": "17/01/2024",
        "deleted_at": null
    }
}
```

</details>

<br/>

#### Response Error 422

![Response](/img/response_error_put_tasks.png)

<details> 
  <summary>Code</summary>

```json
{
    "message": "We need your [ TITLE ] to continue! (and 3 more errors)",
    "errors": {
        "title": ["We need your [ TITLE ] to continue!"],
        "status": ["The selected status is invalid."],
        "priority": ["We need your [ PRIORITY ] to continue!"],
        "deadline": [
            "The deadline field must be a date after or equal to today."
        ]
    }
}
```

</details>

<br>

[Início](#tasks)

---

<br/>
<br/>

## DEL /tasks/{{uuid}}

```
  http://[SUA_URI]/api/v1/tasks/{{uuid}}
```

#### Header

```json
{
    "Authorization": "Bearer {{ token }}"
}
```

<br/>

#### Response Success 200

![Response](/img/response_success_del_tasks.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Success",
    "status_code": 200,
    "message": "Task deleted successfully",
    "data": []
}
```

</details>

<br/>

#### Response Error 404

![Response](/img/response_error_generic_404.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Error",
    "status_code": 404,
    "message": "Unable to perform deletion. The requested resource does not exist!",
    "data": []
}
```

</details>

<br>

[Início](#tasks)

# Diagrama EER

![eer](/eer/diagrama-eer-mysql-api-ezoom.png)
