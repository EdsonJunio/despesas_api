# despesas_api

## Descrição

Este projeto é uma API REST desenvolvida com Laravel para gerenciar despesas dos usuários. A API inclui funcionalidades de autenticação de usuário, CRUD (Create, Read, Update, Delete) de despesas e restrição de acesso.

## Pré-requisitos

- PHP ^8.2
- Composer
- Laravel ^10.10
- Banco de dados (MySQL, PostgreSQL, etc.)

## Instalação

Siga as etapas abaixo para configurar seu ambiente de desenvolvimento.

1. Clone o repositório:
    ```sh
    git clone https://github.com/EdsonJunio/despesas_api
    ```

2. Instale as dependências do Composer:
    ```sh
    composer install
    ```

3. Copie o arquivo `.env.example` para `.env`:
    ```sh
    cp .env.example .env
    ```

4. Gere a chave da aplicação:
    ```sh
    php artisan key:generate
    ```

5. Configure o arquivo `.env` com suas informações de banco de dados.

6. Execute as migrações do banco de dados:
    ```sh
    php artisan migrate
    ```

7.  Popule o banco de dados com dados iniciais:
    ```sh
    php artisan db:seed --class=DespesasSeeder
    ```

## Configuração

Pode ser necessária configuração adicional para certos serviços e pacotes. Certifique-se de configurar:

- Laravel Passport para autenticação de API
- Laravel Sanctum para autenticação de single-page application (SPA)

## Uso

Inicie o servidor de desenvolvimento:
```sh
php artisan serve
```

### Documentação
A documentação da API para utilização no Insomnia está disponível no arquivo .
```sh
https://drive.google.com/file/d/1aaZspdihhsRtNQuJEeFNCAdrFCdtG9lj/view?usp=sharing
```

## Testes

- O ambiente de testes está configurado para usar SQLite. As configurações de ambiente para testes estão no arquivo `.env.testing`.

### Configurações do .env.testing

```php
DB_CONNECTION=sqlite
DB_DATABASE=/despesas_api/database/database.sqlite
```


```sh
php artisan migrate --env=testing
````

### Disparo de E-mail
- Utilização de disparo de e-mails quando uma nova despesa for cadastrada. Os e-mails serão registrados no log do Laravel.

```sh
MAIL_MAILER=log
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=TestUser
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=Seu-email
MAIL_FROM_NAME="${APP_NAME}"
MAIL_DRIVER=log
````

