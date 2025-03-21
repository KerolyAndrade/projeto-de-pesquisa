Para rodar o projeto no seu ambiente:

1-Faça o download do projeto em sua máquina.

2-Execute os seguintes comandos no terminal:

    cp .env.example .env

    php artisan key:generate

    docker build -t [NOME_DO_CONTAINER] .
    
    docker-compose up --build
    
Após isso, o projeto deverá estar acessível normalmente em seu navegador na porta 8081.
Se precisar de mais informações ou tiver dúvidas, não hesite em entrar em contato!
