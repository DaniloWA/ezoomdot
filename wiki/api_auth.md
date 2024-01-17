# Api Auth

<br/>

## Índice

### [Registrando](#post-apiauthregister)

### [Logando](#post-apiauthlogin)

### [Usuário](#get-apiauthme)

### [Deslogando](#post-apiauthlogout)

### [EER](#diagrama-eer)

#### [Voltar pro Readme](/README.md)

---

<br/>
<br/>

## POST /api/auth/register

```
  http://[SUA_URI]/api/v1/auth/register
```

#### BODY

![Body register](/img/body_register_auth.png)

<details> 
  <summary>Code</summary>

```json
{
    "name": "UserTeste",
    "email": "User@gmail.com",
    "password": "123123123",
    "password_confirmation": "123123123"
}
```

</details>

<br/>

#### Response Success 201

![Response](/img/response_success_register.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Success",
    "status_code": 201,
    "message": "User created!",
    "data": {
        "user": {
            "name": "UserTeste",
            "email": "User@gmail.com",
            "uuid": "2016cca7-c155-48b4-bb2b-762f5838d4a5",
            "updated_at": "2024-01-17T06:58:55.000000Z",
            "created_at": "2024-01-17T06:58:55.000000Z"
        },
        "token": "5|yj7O2CKYYQnKC4Nw1rELW5vz0zzW3RBoChRTa1pYdcfb0c27"
    }
}
```

</details>

<br/>

#### Response Error 422

![Response](/img/response_error_register.png)

<details> 
  <summary>Code</summary>

```json
{
    "message": "Someone already picked this [ EMAIL ] try another one!",
    "errors": {
        "email": ["Someone already picked this [ EMAIL ] try another one!"]
    }
}
```

</details>

<br>

[Início](#api-auth)

---

<br/>
<br/>

## POST /api/auth/login

```
  http://[SUA_URI]/api/v1/auth/login
```

<br/>

#### BODY

![Body login](/img/body_login.png)

<details> 
  <summary>Code</summary>

```json
{
    "email": "User@gmail.com",
    "password": "123123123"
}
```

</details>

<br/>

#### Response Success 200

![Response](/img/response_success_login.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Success",
    "status_code": 200,
    "message": "User logged in!",
    "data": {
        "token": "6|WGIoh2rgaXMmHUE6eRsejrfAayNagVB21FrewxiSf9ae89ad",
        "user": {
            "uuid": "2016cca7-c155-48b4-bb2b-762f5838d4a5",
            "name": "UserTeste",
            "email": "User@gmail.com",
            "email_verified_at": null,
            "created_at": "2024-01-17T06:58:55.000000Z",
            "updated_at": "2024-01-17T06:58:55.000000Z"
        }
    }
}
```

</details>

<br/>

#### Response Error 401

![Response](/img/response_error_login_auth.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Error",
    "status_code": 401,
    "message": "The provided credentials are incorrect.",
    "data": []
}
```

</details>

<br>

[Início](#api-auth)

---

<br/>
<br/>

## GET /api/auth/user

```
  http://[SUA_URI]/api/v1/auth/user
```

#### Header

```json
{
    "Authorization": "Bearer {{ token }}"
}
```

<br/>

#### Response Success 200

![Response](/img/response_success_me_auth.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Success",
    "status_code": 200,
    "message": null,
    "data": {
        "uuid": "2016cca7-c155-48b4-bb2b-762f5838d4a5",
        "name": "UserTeste",
        "email": "User@gmail.com",
        "email_verified_at": null,
        "created_at": "2024-01-17T06:58:55.000000Z",
        "updated_at": "2024-01-17T06:58:55.000000Z"
    }
}
```

</details>

<br/>

#### Response Error 401

![Response](/img/response_error_me_auth.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Error",
    "status_code": 401,
    "message": "Authentication failed: User is not authenticated.",
    "data": []
}
```

</details>

<br>

[Início](#api-auth)

---

<br/>
<br/>

## POST api/auth/logout

```
  http://[SUA_URI]/api/v1/auth/logout
```

#### Header

```json
{
    "Authorization": "Bearer {{ token }}"
}
```

<br/>

#### Response Success 200

![Response](/img/response_success_logout_auth.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Success",
    "status_code": 200,
    "message": "Tokens Revoked",
    "data": []
}
```

</details>

<br/>

#### Response Error 401

![Response](/img/response_error_logout_auth.png)

<details> 
  <summary>Code</summary>

```json
{
    "status": "Error",
    "status_code": 401,
    "message": "Authentication failed: User is not authenticated.",
    "data": []
}
```

</details>

<br>

[Início](#api-auth)

# Diagrama EER

![eer](/eer/diagrama-eer-mysql-api-ezoom.png)
