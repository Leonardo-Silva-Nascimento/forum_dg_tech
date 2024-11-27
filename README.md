# Projeto dgTech - Fórum

Este projeto foi desenvolvido como uma extensão de outro projeto presente em meu portfólio, chamado [dg_tech](https://github.com/Leonardo-Silva-Nascimento/dgTech). A ideia foi aprimorar funcionalidades e apresentar um fluxo de fórum funcional.

## Configuração e Execução Local

Siga as etapas abaixo para configurar e executar o projeto em seu ambiente local:

### 1. Criação do Banco de Dados
1. Execute o script de criação do banco de dados utilizando um dos seguintes arquivos disponíveis:
   - `mysql.sql`
   - `/database/BancoDados.sql`
2. Isso criará as tabelas necessárias para o funcionamento da aplicação.

### 2. Configuração do Ambiente
1. Copie o arquivo `.env.example` e renomeie-o para `.env`.
2. Configure as variáveis de ambiente de acordo com o seu ambiente local (exemplo: banco de dados, porta, etc.).

### 3. Executando o Projeto
1. Inicie o servidor do Laravel com o comando:
   ```bash
   php artisan serve
   ```
2. (Opcional) Execute o comando para monitorar alterações no front-end:
   ```bash
   npm run watch
   ```

### 4. Acessando a Aplicação
Após iniciar o servidor, acesse a aplicação pelo navegador. Na interface, você poderá realizar um cadastro pela aba lateral e explorar o fluxo do fórum desenvolvido.

## Contato
Caso tenha dúvidas ou precise de suporte, sinta-se à vontade para entrar em contato pelo e-mail: **leonct13@gmail.com**.
```
