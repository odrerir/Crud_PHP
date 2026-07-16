# CRUD PHP

Projeto CRUD completo com back-end em PHP e front-end em Vite + JavaScript.

## Visão Geral

- `crud-api/`: API REST em PHP usando FrankenPHP e arquivo JSON para persistência.
- `frontend/`: interface web que consome a API e permite criar, editar, apagar e listar usuários.

## Tecnologias

- PHP 8.3 / FrankenPHP para o backend
- Nginx para servir o front-end estático
- Vite
- Axios
- HTML, CSS e JavaScript puro
- JSON para armazenamento simples de dados

## Estrutura do Projeto

- `crud-api/`
  - `Dockerfile`: imagem PHP/FrankenPHP para servir a API.
  - `compose.yaml`: define o serviço backend a partir do Dockerfile e expõe a porta `8000`.
  - `config/config.php`: configuração do arquivo de dados e origens permitidas.
  - `data/data.json`: armazenamento dos usuários.
  - `public/index.php`: roteador básico da API.
  - `src/`: lógica de API, controladores, serviços e validação.

- `frontend/`
  - `Dockerfile`: copia `dist/` para servir com Nginx.
  - `compose.yaml`: define o serviço frontend Nginx mapeando porta `8080`.
  - `package.json`: dependências do Vite e Axios.
  - `src/`: código do app e dos helpers de API/dom.

## Como Executar

### 1. Backend

No diretório `crud-api/`:

```bash
cd crud-api
docker compose up -d --build
```

A API ficará disponível em:

- `http://localhost:8000`

### 2. Frontend

No diretório `frontend/`:

```bash
cd frontend
npm install
npm run build
docker compose up -d --build
```

A interface estará disponível em:

- `http://localhost:8080`

> O front-end chama a API em `http://localhost:8000/api/users`.

## Endpoints da API

- `GET /api/users`
  - Lista todos os usuários.

- `POST /api/users`
  - Cria um novo usuário.
  - Body JSON: `{ "name": "...", "age": 30, "email": "..." }`

- `PUT /api/users?id={id}`
  - Atualiza completamente um usuário existente.
  - Body JSON: `{ "name": "...", "age": 30, "email": "..." }`

- `PATCH /api/users?id={id}`
  - Atualiza parcialmente um usuário.
  - Body JSON pode conter um ou mais campos: `name`, `age`, `email`.

- `DELETE /api/users?id={id}`
  - Remove um usuário.

## Dados

- O arquivo `crud-api/data/data.json` armazena os usuários e o próximo `id`.
- O projeto não usa banco de dados, apenas persistência em JSON.

## Observações

- O backend permite CORS para `localhost:8080` e `localhost:5500` conforme `crud-api/config/config.php`.
- Para alterações no front-end, rode `npm run build` antes de iniciar o container do Nginx.

## Contato

- Adaptar o README conforme necessário para incluir autor, licença ou instruções adicionais.
