







<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).





<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Readme</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<body>

    <h3>Requisitos de Hardware e software para utilização da API</h3>
    <p>- Computador com Composer + Laravel + Artisan instalados em ambiente global</p>
    <p>- Banco de dados do tipo mariaDB ou MySQL devidamente instalado</p>
    <p>- HTTP client instalado, Ex.: <a href= 'https://www.postman.com/' target="_blank">Postman</a></p>
    <p>- Editor de texto/IDE para a edição das variáveis globais</p>

    <h3>Configurando ambiente</h3>
    <p>Crie um Banco de dados e usuário com amplas permissões para essa base de dados.</p>
    <p>No editor de texto/IDE, acesso o arquivo .env. Dentro desse arquivo, edite as informações do banco de dados, inserindo as informações do banco de dados criado.</p>
    <p>Ainda no mesmo arquivo, edite a área de configuração de email, para envio do pedido, quando realizado</p>
    <p>Abra o arquivo app/mail/PedidoRealizado.php e edite as linhas: "$message->from('doc88@gmail.com','Doc88')", colocando as informações do email desejado.<br>Alem disso, edite a linha "$data = array('name'=>"Challenge Doc88");", colocando no array do item name, o nome do remetente </p>

    <h3>Iniciando Banco de dados e inserindo dados iniciais</h3>
    <p>Abra o terminal no diretorio raiz do projeto e insira os seguintes comandos:</p>
    <p>php artisan migrate:fresh</p>
    <p>php artisan db:seed</p>

    <h3>Explicação da API</h3>
    <p>Pronto, agora que o ambiente já está configurado, vamos ver como funciona a API</p>
    <h4>Rotas</h4>
    <p>Todas as rotas partem do endereço {url}/api</p>
    <p>Para cessar as informações do pastel, adicione no endereço /pastel</p>
    <p>Para cessar as informações do cliente, adicione no endereço /cliente</p>
    <p>Para cessar as informações do pedido, adicione no endereço /pedido</p>

    <p>Todos os endpoints seguem o padrão dos verbos de requisição internecional (GET, POST, UPDATE, DELETE)</p>
    <p>Onde o verbo GET lista os registros contidos</p>
    <p>O verbo POST Grava um novo registro</p>
    <p>O verbo UPDATE atualiza o registro especificado</p>
    <p>O verbo DELETE Exclui, por soft delete, o registro especificado</p>

    <h5>Verbo GET em todas as rotas</h5>
    <p>Caso não seja especificado um item desejado, por exemplo: "{url}/api/pastel", ele listará todos os registros de pastel.</p>
    <p>Para visualizar um registro em específico, precisamos apenas especificar na URL o id do item, por exemplo: "{url}/api/pastel/3". Assim, ele retornará as informações do pastel de id 3</p>

    <h5>Verbo POST</h5>
    <p>Cliente, passar os seguintes parametros:</p>
    <ul>
        <li>nome [text]</li>
        <li>email [text]</li>
        <li>telefone [text]</li>
        <li>data_de_nascimento [date yyyy-mm-dd]</li>
        <li>endereco [text]</li>
        <li>complemento [text]</li>
        <li>bairro [text]</li>
        <li>cep [text]</li>
    </ul>

    <p>Pastel, passar os seguintes parametros, no tipo form-data</p>
    <ul>
        <li>nome [text]</li>
        <li>preco [Double]</li>
        <li>photo [File]</li>
    </ul>

    <p>Pedido: Para inserir um pedido, é necessario que haja registros de Pastel e Cliente</p>
    <ul>
        <li>id_cliente [Int (id da tabela Clientes)]</li>
        <li>pastel [json]:
            <ul>
                <li>id_pastel [Int (id da tabela Pastels)]</li>
                <li>quantidade [Int]</li>
            </ul>
        </li>
    </ul>
</body>
</html>
