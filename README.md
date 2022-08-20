# Desafio | Fullstack

O teste consiste em implementar uma lista de contatos e empresas. O projeto, obrigatoriamente, deve ser separado em backend e frontend.

## Backend

O backend **deve** ser desenvolvido em `php` e **deve** conter uma API Rest.

O sistema deve conter as seguintes entidades e seus respectivos campos:

- Usuário
    - Nome: obrigatório para preenchimento
    - E-mail: obrigatório para preenchimento
    - Telefone: não obrigatório
    - Data de nascimento: não obrigatório
    - Cidade onde nasceu: não obrigatório
    - Empresas: obrigatório para preenchimento

- Empresa
    - Nome: obrigatório para preenchimento
    - CNPJ: obrigatório para preenchimento
    - Endereço: obrigatório para preenchimento
    - Usuários: obrigatório para preenchimento

A regra de relacionamento para `Usuário` e `Empresa` deve ser de __n para n__

### Banco
Você **deve** utilizar um banco de dados para o sistema. Pode-se escolher qualquer opção que desejar, mas o seguite cenário deve ser levado em consideração:
- O sistema lida com informações sensíveis e preza pela integridade dos dados
- O sistema lida com diferentes entidades relacionadas

Pedimos para que nos sinalize o motivo da escolha do banco no final do documento

***Foi utilizado o Postgres por fornecer mais recursos que o MySql***


## Testes
Testes unitários **devem** ser implementados no backend para validação das operações do CRUD.

Testes unitários **devem** ser implementados no frontend para a tela de exibição dos usuários.

Você pode utilizar o framework de sua preferência tanto para o backend quanto para o frontend.

## Ambiente
Aqui na Contato Seguro, utilizamos __Docker__ nos nossos ambientes, então será muito bem visto caso decida utilizar. Principalmente para que tenhamos o mesmo resultado (mesma configuração de ambiente). Caso desenvolva com docker, nos envie junto com o projeto o `docker-compose.yml` e/ou os `Dockerfile´`s.

## Requisitos mínimos
- As 4 operações CRUD, tanto para entidade `Usuário`, quanto para `Empresa`. Todas as operações devem ter rotas específicas no backend.
- O filtro de registros
- Código legível, limpo e seguindo boas práticas de Orientação a Objetos
- Um dump ou DDL do banco de dados
- Testes unitários
- Utilizar Docker
- Separação em commits, especialmente com boas mensagens de identificação.

## Requisitos bônus
- Outras entidades e relacionamento entre entidades. Por exemplo: uma entidade `Relatos` ou `Atividades` que tenha `Usuários` e/ou `Empresas` vinculadas.

# Resposta do participante
_Responda aqui quais foram suas dificuldades e explique a sua solução_
- Ficou um pouco confuso a descrição de como deveria ser realizado o desenvolvimento, me ambasei em outros projetos que eu já trabalhei para realizar o teste.

___

## Instalação do projeto

Após realizar o clone do projeto, acesse o diretório docker que está dentro do projeto via linha de comando. 

Execute o comando:
> docker-compose up -d nginx postgres

Quando finalizar o build do docker o projeto já deverá estar funcionando

Volte para o diretório do projeto e execute o comando:
> docker exec -it [nome do container] /bin/bash

Faça a cópia do env.example
> cp .env.example .env

Faça a configuração com os parâmetros necessários.

Execute os comandos:
> php artisan optimize
> 
> php artisan migrate
> 
> ./vendor/bin/phpunit

O projeto deverá estar funcinal e com os testes realizados.
