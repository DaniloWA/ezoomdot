# Postman

<br/>

## Índice

### [Importando](#importando-suite)

### [Variáveis ambiente](#variáveis-environments)

### [Seções endpoints](#seções)

-   [Auth](#api-auth)
-   [Tasks](#tasks)

### [Scripts Variáveis](#scripts)

### [Ordem de Testes](#ordem-de-uso)

#### [Voltar pro Readme](/README.md)

---

<br>

# Importando suite

### Importar suite de endpoints para o [Postman](/postman) (ficheiros)

```bash
  cd ./postman
```

<br>

> **Observação**: Estes gifs servem apenas como um guia visual, utilize-o em conjunto com os arquivos fornecidos para uma configuração eficiente..

### Passo a Passo para importação do ficheiro do endpoint pelo GUI

![import collection](/img/gif-import-collection-api.gif)

<br>

### Passo a Passo para importação do ficheiro do environment pelo GUI

![import environment](/img/gif-import-environment-api.gif)

#### (Opcional) Para visualizar os dados dos endpoints

```bash
  cat .\postman\api_ezoom_dev.postman_collection.json
```

#### (Opcional) Para visualizar os dados do ambiente local do environment

```bash
  cat .\postman\api_ezoom_dev.postman_environment.json
```

<br>

[Início](#postman)

---

<br>

# Variáveis environments

| Variáveis    | Descrição                                   |
| :----------- | :------------------------------------------ |
| `apiroute`   | Url de todos os Endpoints                   |
| `apiversion` | Versão da Api                               |
| `api_token`  | Token de autenticação em todos os endpoints |
| `task_uuid`  | UUID da secção dos tasks                    |

<br>

[Início](#postman)

---

<br>

# Seções

<br>

## Api Auth

#### API Register

> Rota utilizada para registrar usuário na api

<br>

```
  POST /api/v1/auth/register
```

<br>

[Início](#postman)

---

<br>

#### API Login

> Rota utilizada para logar usuário na api

<br>

```
  GET /api/v1/auth/login
```

<br>

[Início](#postman)

---

<br>

#### Api User

> Rota retorna usuário logado na api

```
  GET /api/v1/auth/user
```

| Headers         | value                  | Descrição                         |
| :-------------- | :--------------------- | :-------------------------------- |
| `Authorization` | `Bearer {{api_token}}` | **Obrigatório**. Token do usuário |

<br>

[Início](#postman)

---

<br>

#### Api Logout

> Rota Desloga o usuário da api

```
  POST /api/v1/auth/logout
```

| Headers         | value                  | Descrição                         |
| :-------------- | :--------------------- | :-------------------------------- |
| `Authorization` | `Bearer {{api_token}}` | **Obrigatório**. Token do usuário |

<br>

[Início](#postman)

---

<br>

## Tasks

#### Tasks - Store

> Rota cria uma task

```
  POST /api/v1/tasks
```

| Headers         | value                  | Descrição                         |
| :-------------- | :--------------------- | :-------------------------------- |
| `Authorization` | `Bearer {{api_token}}` | **Obrigatório**. Token do usuário |

<br>

[Início](#postman)

---

<br>

#### Tasks - Index

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

<br>

[Início](#postman)

---

<br>

#### Tasks - Show

> Retorna o usuário encontrado pelo UUID

```
  GET /api/v1/tasks/{{task_uuid}}
```

| Headers         | value                  | Descrição                         |
| :-------------- | :--------------------- | :-------------------------------- |
| `Authorization` | `Bearer {{api_token}}` | **Obrigatório**. Token do usuário |

| params      | value  | Descrição                                      |
| :---------- | :----- | :--------------------------------------------- |
| `task_uuid` | `uuid` | **Obrigatório**. Identificador único da tarefa |

<br>

[Início](#postman)

---

<br>

#### Tasks - Put

> Rota atualiza uma task pelo UUID

```
  PUT /api/v1/tasks/{{task_uuid}}
```

| Headers         | value                  | Descrição                         |
| :-------------- | :--------------------- | :-------------------------------- |
| `Authorization` | `Bearer {{api_token}}` | **Obrigatório**. Token do usuário |

| params      | value  | Descrição                                      |
| :---------- | :----- | :--------------------------------------------- |
| `task_uuid` | `uuid` | **Obrigatório**. Identificador único da tarefa |

<br>

[Início](#postman)

---

<br>

#### Tasks - Delete

> Rota deleta uma task pelo UUID

```
  DELETE /api/v1/tasks/{{task_uuid}}
```

| Headers         | value                  | Descrição                         |
| :-------------- | :--------------------- | :-------------------------------- |
| `Authorization` | `Bearer {{api_token}}` | **Obrigatório**. Token do usuário |

| params      | value  | Descrição                                      |
| :---------- | :----- | :--------------------------------------------- |
| `task_uuid` | `uuid` | **Obrigatório**. Identificador único da tarefa |

<br>

[Início](#postman)

---

<br>

# Scripts

Os endpoints [Register](#api-register) e [Login](#api-login) teem esse script que preenche a variável {{ api_token }} automaticamente assim que é feito a requisição de login ou register para facilitar o acesso ao resto das rotas!

```javascript
var response = JSON.parse(responseBody);

postman.setEnvironmentVariable("api_token", response.data.token);
```

<br>

O endpoint - Store teem esse script para preencher a variáveil task_uuid

Agilizando o acesso as rotas de pesquisa, atualização e de remoção dos recursos.

exemplo :

```javascript
try {
    var responseData = pm.response.json();

    if (responseData && responseData.data && responseData.data.uuid) {
        postman.setEnvironmentVariable("task_uuid", responseData.data.uuid);
    } else {
        console.log("The response body does not contain 'data.uuid'");
    }
} catch (error) {
    console.error("Error parsing the JSON body of the response:", error);
}
```

<br>

[Início](#postman)

---

<br>

# Ordem de Uso

Por questão dos scripts e variáveis recomendo que sigam esse cronograma para um perfeito funcionamento da collection.

#### Register ou Login

> Assim será preenchido a variável do Token de todas as rotas.

#### Store, sempre primeiro!

> Assim será preenchido a variável do UUID da secção.

<br>

[Início](#postman)
