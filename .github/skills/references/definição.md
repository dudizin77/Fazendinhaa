

Curso Técnico de Nível Médio em Informática – Forma Integrada

Programação Web II
Definição do Trabalho Prático da Disciplina
Prof. Fábio Luís da Silva Santos
Em duplas, projete e implemente um sistema Web, no formato micro SaaS (Software as a Service), para ser utilizado em uma empresa/instituição/portal na área e ramo de atividade de sua preferência. O sistema deve se inserir em uma situação do mundo real, podendo ser na área comercial, industrial ou de serviços. Na dúvida, converse com o professor.
O sistema deve ser implementado aplicando conceitos avançados de desenvolvimento Web, como Orientação a Objetos, Padrão de Desenvolvimento Model-View-Controller (Modelo-Visualização-Controle MVC), APIs RESTful e geração de relatórios, integrando tecnologias de front-end e back-end, além disso utilizar as seguintes tecnologias:
Composer (gerenciador de dependências)
Git e GitHub (gerenciador de versionamento)
HTML5
CSS
JavaScript com Orientação a Objetos Prototípica
PHP Orientado a Objetos
Tratamento de Erros
Inserção de componentes auxiliares implementados por terceiros para: 
gerenciar rotas amigáveis;
autenticação com (JSON Web Token) JWT
manipulação de documentos no formato PDF; 
geração de gráficos, imagens (upload e acesso); 
envio e gerenciamento de emails.
Implementação de um Web Service, com objetivo de servir informações para uma Aplicação Mobile (desenvolvida na disciplina de Programação de Dispositivos Móveis).
Banco de Dados MySQL (Maria DB)
A organização das pastas deve seguir a estrutura que se encontra no GitHub no link publicado no Moodle.
É importante ter em mente que o sistema, seja qual for a realidade no qual está inserido, será dividido em no mínimo 3 partes:
Área Pública - é aquela que todos podem acessar  sem a necessidade de se ter um cadastro ou utilização de uma senha para entrar (se for uma loja, por exemplo, onde se pode ver as ofertas, o que se vende, o link Sobre Nós, Localização, Contato, ou seja, as informações institucionais);
Área Aplicação (restrita) - onde o para entrar é necessário possuir um cadastro mínimo (Nome, Email e Senha) (no caso da loja, é onde o usuário entra para fornecer os dados do seu perfil, realizar compras, etc);
Área Administrativa (restrita) - onde só entra quem vai administrar o sistema como um todo (exemplo da loja, área onde o gerente ou lojista vai cadastrar os produtos, colocá-los a venda, gerenciar ofertas, etc).
Planejamento e Estruturação Inicial
SE1 - Etapa 01 - Definição por Escrito - Peso 2 pontos
Etapa 1.1: definir por escrito o escopo do trabalho/sistema a ser desenvolvido, para isso utilize o documento abaixo:
Modelo do Documento
Etapa 1.2: nessa etapa, é importante que cada dupla crie uma pasta no Google Drive, sendo que a mesma deve ser compartilhada com o professor (fabiosantos@ifsul.edu.br), o compartilhamento deve permitir edição por parte do professor. Faça upload da definição do trabalho (documento acima) para essa pasta. Abaixo segue o link para um arquivo onde deve ser informado ao lado do seu nome o link para a pasta que foi criada e compartilhada com professor:
Turma Manhã: INF-3AM
Turma Tarde: INF-3AT
Atenção: tanto a pasta quanto o arquivo compartilhados comigo devem ser editáveis, portanto eu preciso da permissão para editar o arquivo com a definição do trabalho e de permissão para criar arquivos na pasta!
O documento é composto por 6 seções, nesta etapa documento seu sistema nos itens Resumo, Área de Atuação e Público Alvo.
Resumo
O texto resumindo o sistema como um todo, deve ser conciso, focado e direto ao ponto, e deve ter como objetivo apresentar as principais funcionalidades e características do mesmo, com o mínimo de palavras possível. É importante ter em mente que o objetivo de um resumo é fornecer uma visão geral clara das principais características e funcionalidades que o sistema oferece para promover as melhorias nas atividades da área na qual está inserido.
Área de Atuação
Descreva em qual setor o sistema será aplicado (comercial, industrial, serviços, etc.). Explique qual problema ele resolve e quais são os desafios enfrentados atualmente no setor sem o uso do sistema. Caso o sistema seja voltado para uma empresa real ou fictícia, forneça detalhes sobre sua estrutura e funcionamento.
Público Alvo
Identifique quem utilizará o sistema e quais são suas necessidades. Detalhe o perfil dos usuários, como idade, nível de experiência com tecnologia e contexto de uso do sistema. Caso existam diferentes tipos de usuários (clientes, funcionários, administradores), explique quais funcionalidades cada um terá acesso.
Objetivos Geral
Defina de forma clara e objetiva qual o propósito principal do sistema. Exemplo: "O objetivo deste sistema é automatizar o gerenciamento de pedidos em uma loja virtual, permitindo maior controle sobre o estoque e reduzindo erros operacionais"
Objetivos Específicos (Liste os objetivos menores que contribuem para atingir o objetivo geral) Exemplo:
Implementar um cadastro de clientes e produtos.
Criar um painel administrativo para gerenciar pedidos.
Desenvolver uma API REST para integração com aplicativos móveis.
Permitir a geração de relatórios sobre vendas e estoque.
Conclusões (fazer no final)
resumo dos principais objetivos do sistema e como eles podem contribuir com melhorias no fluxo de trabalho no ambiente onde está inserido, conclusão geral sobre o desempenho do software e suas contribuições para a área de atuação na qual está inserido. Sugestões para futuras implementações de novas funcionalidades.
Data de Entrega: 30/04/2026
SE1 - Etapa 02 - Layout do Sistema - Visualização - Peso 2 pontos
Desenvolva/implemente o tema/layout/front-end para a área pública do sistema contendo minimamente:
Área Pública - onde todos os usuários chegam, não há necessidade de credenciamento/login para acessar
Home - página inicial;
Sobre (link com informações institucionais);
Contato (link com informações de contato da empresa [endereço, telefone, localização etc], inclusive formulário para mensagem);
Formulário de Registro/Cadastro de usuário solicitando Nome, Email e Senha;
Formulário de Login para o usuário entrar na Área Aplicação (área restrita);
Perguntas mais Frequentes (FAQs)
Área de Aplicação - onde seu principal usuário vai chegar, depois de ter realizado o cadastro e credenciamento/login
Perfil do Usuário - onde o usuário poderá alterar os dados do seu prefil (nome, e-mail, senha, endereço, foto, etc
Gestão de seus dados (CRUDs) - onde o usuário realizará o “consumo” do seu serviço, compra de produtos, etc… Aqui depende muito cada ideia proposta, na dúvida consulte o professor
Área administrativa - dashboard com as informações sobre como está funcionando o serviço, o sistema como um todo.
Perfil do Usuário Administrador
Gerenciamento de novos Administradores (CRUD) - aqui depende muito da cada uma das ideias proposta, por exemplo, um serviço de vendas, necessita do cadastro dos produtos, alteração das informações dos produtos, etc…
Gerenciamento dos Serviços (CRUDs) -  aqui depende muito da cada uma das ideias proposta, por exemplo, um serviço de vendas, necessita do cadastro dos produtos, alteração das informações dos produtos, etc…
Gestão das Perguntas mais Frequentemente (FAQs) (CRUD) - uma área para realizar a gestão das Perguntas e Respostas mais Frequentes, incluir novas, excluir, publicar, “despublicar”, alterar perguntas e respostas.
Data de Entrega: 21/05/2026
SE1 - Etapa 03 - Webservice - Peso 
Banco de Dados
No texto entregue na Primeira Etapa, crie uma seção para o universo de discurso do banco de dados, isto é, a definição da realidade do sistema falando sobre o objetivo de cada entidade e suas relações com as demais. Crie também o ER utilizando o Workbench ou outra ferramenta gráfica. Por fim criar o banco de dados.
Rotas da API
Nesta etapa, você deverá projetar e implementar um Web Service para o sistema que está sendo desenvolvido. O Web Service terá como objetivo, além de fornecer uma interface para o próprio front end do sistema, fornecer também uma interface para que uma Aplicação Mobile, desenvolvida na disciplina de Programação de Dispositivos Móveis, possa interagir com os dados do sistema.
Para entidade principal do sistema e mais uma a sua escolha, desenvolva as seguintes rotas para cada uma das entidades, aqui exemplificada com a entidades Produtos:
$route->group("/products");
$route->get("/list/{product_id}","Products:listById"); // select by id
$route->get("/list","Products:listAll"); // select all
// select all
$route->get("/list/paginator/{page}/{per_page}","Products:listPaginator");
$route->post("/","Products:insert"); // insert
$route->put("/{product_id}","Products:update"); // update
$route->delete("/{product_id}","Products:delete"); // update
$route->group(null);
Autenticação
Para as rotas que necessitem de autenticação: o acesso às rotas do Web Service deve ser controlado utilizando autenticação via JSON Web Tokens (JWT), para tanto utiliza as classes disponibilizadas no repositório.
Documentação
Deve ser fornecida uma documentação clara e detalhada do Web Service, incluindo a descrição das rotas, parâmetros aceitos, exemplos de requisições e respostas, além dos códigos de status HTTP retornados em cada caso. O código do Web Service deve ser versionado utilizando Git e disponibilizado no GitHub. A documentação do Web Service deve ser entregue em um arquivo README.md, dentro do repositório GitHub (na pasta api).
Data de Entrega: 23/06/2026
Integração, Refino e Apresentação
SE2 - Etapa 05 - Integração do Backend (Web Service) com o Frontend

Nesta etapa, você precisa conectar o backend (webservice) com o frontend usando JavaScript. Aqui estão alguns passos para realizar essa integração:
Endpoints: Certifique-se de que o webservice tenha endpoints (rotas) para as operações que o frontend precisa realizar (por exemplo, criar, ler, atualizar e excluir registros de todas as tabelas do Banco de Dados).
Chamadas Fetch: No frontend, utilize chamadas assíncronas para fazer requisições HTTP ao webservice. Isso permitirá que o frontend obtenha ou envie dados para o backend, por exemplo:
fetch(`http://localhost/mvc-project-tarde/api/services/list-by-category/category/1`,{
   method: "GET"
}).then((response) => {
   response.json().then((services) => {
           console.log(services);
       });
});
Manipulação de Respostas: Trate as respostas do webservice no frontend. Por exemplo, se você estiver obtendo dados, atualize a interface do usuário com esses dados. Se estiver enviando dados, lide com possíveis erros ou confirmações.
A entidade principal do sistema (o objeto central no seu domínio) e mais duas entidades devem ter as operações CRUD (Create, Read, Update, Delete) implementadas (no frontend e no backend). Aqui estão os detalhes:
Create (Criar): Implemente a funcionalidade para criar novos registros dessa entidade. Isso pode ser feito por meio de um formulário no frontend que envia dados para o webservice.
Read (Ler): Permita que o usuário visualize os registros existentes. Isso pode ser uma lista ou uma visualização detalhada.
Update (Atualizar): Forneça uma maneira de editar os registros. Novamente, isso pode ser feito por meio de formulários.
Delete (Excluir): Implemente a exclusão de registros. Certifique-se de confirmar com o usuário antes de excluir permanentemente.
SE2 - Etapa 06 - Implementação de Upload e Manipulação de Imagens
Objetivo: para Usuários e a Entidade Principal do Sistema, implementar a funcionalidade de upload e manipulação de imagens no sistema utilizando a classe `sorfabiosantos/uploader` em `https://packagist.org/packages/sorfabiosantos/`.  
Para usuário foto de perfil. Para a Entidade Principal n imagens.
Implementação de Upload de Imagens:  
Criar rotas para upload de imagens.
Implementar métodos nos controladores para lidar com o upload e armazenamento de imagens.
Validar o tipo e tamanho das imagens.
Manipulação de Imagens:  
Redimensionar, cortar ou aplicar filtros nas imagens conforme necessário.
Salvar as imagens manipuladas no servidor na pasta /storage.
É recomendável que a pasta /storage seja incluída no .gitignore
Frontend:  
Adicionar formulários para upload de imagens.
Implementar chamadas assíncronas para enviar imagens ao backend.
Exibir as imagens carregadas/manipuladas na interface do usuário.
Testes que serão realizados na avaliação
Perfil do Usuário
Cadastro de Usuário
Inclusão da imagem do Usuário
Alteração de e-mail, senha e imagem do Usuário
Logout
Login como novo e-mail e senha
Entidade Principal
Cadastrar um novo registro da entidade principal
Incluir n imagens desse novo registro
Verificar se as mesmas estão aparecendo no frontend
SE2 - Etapa 06.1 - Envio de E-mail
Utilizando a biblioteca PHPMailer implemente o sistema de recuperação de senha através do envio de um e-mail para o usuário com um link para criar uma senha nova. No seu e-mail do Gmail acesse as configurações, acesse Segurança e na barra de pesquisa digite “Senhas de app”. Aqui é possível criar uma senha especial para que seu e-mail possa ser acessado pelo sua aplicação para enviar e-mail. Consulte a documentação da PHPMailer.
Depois implemente mais uma funcionalidade que utilize o envio de e-mail.
SE2 - Etapa 07 - JavaScript Orientação a Objetos - Clássica
Objetivo: reescrever parte do código JavaScript do seu sistema utilizando os conceitos de Orientação a Objetos. Crie uma branch nova no seu repositório chamada `javascript-poo`, para você manter funcionando o que já foi feito até aqui.
07.1 Para as principais entidades do sistema, crie as classes em JavaScript, as mesmas devem conter:
os atributos/propriedades
método construtor
getters e setters
os principais métodos. 
Um exemplo inicial da classe User, que pode ser visualizado aqui.
07.2 (Não Obrigatório) No nosso repositório na pasta assets/_shared/js temos duas classes: 
HttpClientBase.js:
é uma classe JavaScript projetada para lidar com requisições HTTP com uma URL base e cabeçalhos padrão. Ela encapsula métodos para definir e limpar um token de autenticação, construir URLs com parâmetros e fazer requisições HTTP usando diferentes métodos (GET, POST, PUT, DELETE).  A classe possui dois campos privados: #baseUrl e #defaultHeaders. O #baseUrl é inicializado no construtor e representa a URL base para todas as requisições. O #defaultHeaders é um objeto que contém cabeçalhos padrão para as requisições, inicializado com um Content-Type de application/json. Em resumo, é uma classe que abstrai o fetch.
HttpService.js:
é uma classe filha de HttpClientBase que possui métodos específicos para acessar as rotas da API relacionadas com Serviços..
O que deve ser feito:
Estendendo a classe HttpClientBase.js, utilizando como exemplo a classe HttpService, crie a classe HttpUser.js e utilize-a para fazer o cadastro de usuário (POST), login (GET) e alteração das informações do mesmo (PUT). 
Para a entidade principal do sistema, faça o mesmo. No CRUD que já deve estar funcionando substitua todas as ocorrências da função fetch pela utilização das classes criadas.
A partir da padronização dos retornos das rotas da API, crie uma classe para exibir em um toast as mensagens retornadas, sendo que dependendo do tipo de retorno a cor do toast deve ser diferente, vermelho “error”, amarelo “warning” e verde para “succes”:
[
   "type" => "error",
   "message" => "Mensagem de erro..."
];
[
   "type" => "warning",
   "message" => "Mensagem de aviso..."
];
[
   "type" => "success",
   "message" => "Mensagem de sucesso..."
];
ou
[
   "type" => "success",
   "message" => "Produto cadastrado com sucesso...",
   "data" => [
	        	"id" => 12,
                  "name" => "Máquina de lavar roupa"
             ]	
];
SE2 - Etapa 08 - JavaScript Orientação a Objetos - Prototípica
Aplique os conceitos da Orientação a Objetos Prototípica no código JavaScript do seu código.
SE2 - Etapa 09 - Apresentação - Final
A apresentação final do trabalho será realizada para toda turma com projetor. Serão disponibilizados o total de 10 minutos para cada estudante, sendo divididos da seguinte forma:
8 minutos para apresentação;
2 minutos para perguntas do professor. 
Deverá ser preparada uma apresentação de slides, com no máximo 3 minutos, com os seguintes tópicos:
Introdução:
Área de Atuação do Sistema;
Público Alvo do Sistema.
Objetivos:
Objetivo Geral;
Objetivos Específicos.
Funcionamento (prints das telas principais):
Área Web;
Área App;
Área Administrativa;
API.
Nos 5 minutos finais, a apresentação deverá conter a demonstração do sistema com suas principais funcionalidades (áreas Web, App, Administrativa e API).
Avaliação
A avaliação será baseada nos seguintes critérios:
Desenvolvimento Técnico (qualidade do código, uso correto das tecnologias);
Funcionalidade e Integração (operação correta do sistema e comunicação entre as áreas);
Usabilidade e Design (experiência do usuário e organização visual);
Documentação (clareza e detalhamento das informações);
Apresentação Final (clareza na exposição e demonstração).
Observações Finais
O código deve ser versionado no GitHub e atualizado regularmente;
A integração da API pode ser testada com Postman antes da implementação no front-end;
O projeto deve seguir boas práticas de programação e estruturação de pastas.
