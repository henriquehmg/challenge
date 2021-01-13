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
    <p>php artisan serve</p>
    <small><b>OBS.:</b> Os dados inseridos inicialmente no banco de dados de Pastel são aleatorios.</small>

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
        <li>pastel [String json]:
            <ul>
                <li>id_pastel [Int (id da tabela Pastels)]</li>
                <li>quantidade [Int]</li>
            </ul>
        </li>
    </ul>

    <h5>Verbo DELETE em todas as rotas</h5>
    <p>Para excluir um registro, precisamos apenas especificar na URL o id do item, por exemplo: "{url}/api/pastel/3". Assim, ele fará o soft delete do pastel de id 3</p>

    <h5>Verbo UPDATE</h5>
    <p>Cliente, especificar na URL o ID do cliente a ser atualizado. Passar os seguintes parametros opcionais para atualização:</p>
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

    <p>Pastel, especificar na URL o ID do pastel a ser atualizado. Passar os seguintes parametros opcionais, no tipo form-data</p>
    <ul>
        <li>nome [text]</li>
        <li>preco [Double]</li>
        <li>photo [File]</li>
    </ul>
    <p>Pedido, especificar na URL o ID do pedido a ser atualizado. Passar os seguintes parametros opcionais, no tipo form-data</p>

    <p>Para alterar o cliente:</p>
    <ul>
        <li>cliente [Int (id da tabela cliente)]</li>
    </ul>

    <p>Para adicionar pastel:</p>
    <ul>
        <li>novoPastel [String json]
            <ul>
                <li>quantidade [Int]</li>
                <li>id_pastel [Int (id da tabela pastels)]</li>
            </ul>
        </li>
    </ul>

    <p>Para excluir pastel:</p>
    <ul>
        <li>removePastel [String json]
            <ul>
                <li>id_pastel [Int (id da tabela pastels)]</li>
            </ul>
        </li>
    </ul>

    <p>Para alterar quantidade de pastel:</p>
    <ul>
        <li>pastel [String json]
            <ul>
                <li>id_pastel [Int (id da tabela pastels)]</li>
                <li>quantidade [Int]</li>
            </ul>
        </li>
    </ul>


    <h3>Retornos</h3>
    <p>Os retornos dessa APi são de base Json</p>

    <h5>Author: Henrique Maraschin Granja</h5>
</body>
</html>
