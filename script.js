/* O arquivo esta organizado em 3 partes, a 
* Primeira parte é a declaração de variaveis e constantes,
* Segunda parte é a declaração de funções
* Terceira parte é a chamada das funções e eventos  da interface
  Todo o código esta em um bloco de código que é executado quando o DOM é carregado,
    para que o código só seja executado quando a pagina estiver carregada.
*/
document.addEventListener('DOMContentLoaded', function () {

    const apiUrl = 'http://localhost/api/v1/index.php'; // Substitua pela URL correta da sua API
    let bntCadastrar = document.getElementById('bntCadastrar');
    let bntSalvar = document.getElementById('bntSalvar');
    let bntCancelar = document.getElementById('bntCancelar');
    
    //escondendo o botão salvar e cancelar
    bntSalvar.style.display = 'none';
    bntCancelar.style.display = 'none';
    /*  Antes de começar o código com a chamada das funções, é importante entender o que cada função faz,
    *  e como ela é chamada, para isso segue uma breve descrição de cada função.
    * fetchListasPessoas() - Faz a requisição para a API e atualiza a lista de pessoas
    * fetchCadastrarPessoa(nome, sobrenome, email, idade) - Faz a requisição para a API e atualiza a lista de pessoas
    * fetchSalvaPessoa(id, nome, sobrenome, email, idade) - Faz a requisição para a API e atualiza a lista de pessoas
    * fetchDeletePessoa(id) - Faz a requisição para a API e atualiza a lista de pessoas
    * addPersonTable(objetoPessoa) - Atualiza a tabela com a listagem de pessoa, que recebe um JSON de parametroque são os dados da vidos da API"
    * 
    * Para acessar a API usamos a função fetch, que é uma função nativa do javascript, que faz requisições HTTP, e retorna uma promisse
    * que é um objeto que representa uma operação assíncrona, que pode ter sucesso ou falha.
    * 
    * Para entender melhor o que é uma promisse, segue um link para um artigo que explica de forma simples o que é uma promisse
    * https://medium.com/@alcidesqueiroz/javascript-ass%C3%ADncrono-promises-e-async-await-e44d3e9601a1
    * 
    * A estrutura geral de uma promisse é a seguinte:
    * fetch(apiUrl)
    *   .then(response => {})
    *   .then(data => {})
    *   .catch(error => {})
    * }
    * Ao chamar a função fetch, é feita a requisição para a API, e o retorno é uma promisse, que é tratada pelo método then,
    * por isso colocamos no .then(response => {}), uma função que recebe como parametro a resposta da requisição, e dentro da função
    * tratamos a resposta, no caso, chamamos a função json() que retorna uma promisse, que é tratada pelo método then, por isso colocamos
    * 



    /* Função para listar pessoas que faz a requisição para a API e atualiza a lista de pessoas */
    function fetchListasPessoas() {
        fetch(apiUrl)//faz a busca na api sem parametros da requisição, que poderia ser passados como um obnjeto json
            .then(response => {//trata a resposta
                return response.json()
            }
            )
            .then(data => {//trata o json retornado
                const peopleList = document.getElementById('listaPessoas');
                peopleList.innerHTML = ''; // Limpar a lista atual
                console.log(data);
                data.forEach(pessoa => {
                    // Adicionar cada pessoa na lista
                    addPersonTable(pessoa);
                });
            })
            .catch(error => console.error('Erro ao listar pessoas:', error));
    }

    //* Função para criar pessoa que faz a requisição para a API e atualiza a lista de pessoas */
    function fetchCadastrarPessoa(nome, sobrenome, email, idade) {
        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ nome, sobrenome, email, idade})
        })
        .then(response => {
                if (!response.ok) {
                    throw new Error(`Erro HTTP! status: ${response.status}`);
                } else if (response.headers.get("Content-Type").includes("application/json")) {
                    return response.json();
                } else {
                    return response.text().then(text => { throw new Error(text) });
                }
            })
            .then(data => {
                // Atualizar a lista de pessoas
                fetchListasPessoas();

            })
            .catch(error => console.error('Erro ao criar pessoa:', error));
    }
    //* Função para editar pessoa que faz a requisição para a API e atualiza a lista de pessoas */
    function fetchSalvaPessoa(id, nome, sobrenome, email, idade) {
        fetch(apiUrl, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id, nome, sobrenome, email, idade })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erro HTTP! status: ${response.status}`);
                } else if (response.headers.get("Content-Type").includes("application/json")) {
                    return response.json();
                } else {
                    return response.text().then(text => { throw new Error(text) });
                }
            })
            .then(data => {
                // Atualizar a lista de pessoas
                fetchListasPessoas();
            })
            .catch(error => console.error('Erro ao editar pessoa:', error));
    }


    /* Função para excluir pessoa que faz a requisição para a API e atualiza a lista de pessoas */
    function fetchDeletePessoa(id) {
        fetch(`${apiUrl}?id=${id}`, {
            method: 'DELETE',
        })
            .then(response => {
                if (!response.ok) {
                    // Tenta ler a mensagem de erro do corpo da resposta
                    return response.text().then(text => {
                        let errorMsg = `Erro HTTP! status: ${response.status}`;
                        try {
                            // Tentativa de analisar o texto como JSON
                            let errData = JSON.parse(text);
                            errorMsg += ': ' + (errData.message || JSON.stringify(errData));
                        } catch (e) {
                            // Se não for JSON, usa o texto bruto da resposta
                            errorMsg += `: ${text}`;
                        }
                        throw new Error(errorMsg);
                    });
                }
                return response.json();
            })
            .then(data => {
                // Atualizar a lista de pessoas
                fetchListasPessoas();
            })
            .catch(error => console.error('Erro ao excluir pessoa:', error.message, error));
    }


    /*Função para atualizar a tabela com a listagem de pessoa, que recebe um JSON de parametroque são os dados da vidos da API"*/
    function addPersonTable(objetoPessoa) {
        const peopleList = document.getElementById('listaPessoas');
        peopleList.innerHTML += `<tr id=${objetoPessoa.id}><td class="id">${objetoPessoa.id}</td>
                                    <td class="nome" >${objetoPessoa.nome}</td>
                                    <td class="sobrenome">${objetoPessoa.sobrenome}</td>
                                    <td class="email">${objetoPessoa.email}</td>
                                    <td class="idade">${objetoPessoa.idade}</td>
                                    <td><button class="bntExcluir">Excluir</button>  <button class="bntEdit">Editar</button></td> </tr>`;
    }


    /* Adicionar evento de click no botão cadastrar do formulario, para criar pessoa nova */
    bntCadastrar.addEventListener('click', function (e) {
        console.log('clicouEmCadastrar');
        pessoa = null;
        pessoa= new Object();
        pessoa.nome = document.getElementById('nome').value;
        pessoa.sobrenome = document.getElementById('sobrenome').value;
        pessoa.email = document.getElementById('email').value;
        pessoa.idade = document.getElementById('idade').value;
        /*Na chamda cadastrarPessoa, seria mais adequado passar o objeto pessoa como parametro, para facilitar a leitura do codigo,
        foi passado os atributos do objeto pessoa como parametros, assim facilita a compreesão */
        fetchCadastrarPessoa(pessoa.nome, pessoa.sobrenome, pessoa.email, pessoa.idade);
        
    });
    /* Adicionar evento de click no botão salvar, para editar pessoa em edição*/
    bntSalvar.addEventListener('click', function (e) {
        console.log('clicouEmSalvar');
        const id = document.getElementById('id').value;
        const nome = document.getElementById('nome').value;
        const sobrenome = document.getElementById('sobrenome').value;
        const email = document.getElementById('email').value;
        const idade = document.getElementById('idade').value;
        fetchSalvaPessoa(id, nome, sobrenome, email, idade);
        //limpando os campos
        document.getElementById('id').value = '';
        document.getElementById('nome').value = '';
        document.getElementById('sobrenome').value = '';
        document.getElementById('email').value = '';
        document.getElementById('idade').value = '';
        //habilitando o botão cadastrar
        bntCadastrar.style.display = 'block';
        bntSalvar.style.display = 'none';
        bntCancelar.style.display = 'none';

    }
    );

    /* Adicionar evento de click no botão excluir, para excluir pessoa */
    document.getElementById('listaPessoas').addEventListener('click', function (e) {
        if (e.target.className == 'bntExcluir') {
            const id = e.target.parentElement.parentElement.firstChild.textContent;
            fetchDeletePessoa(id);
        }
    });
    /* Adicionar evento de click no botão cancelar, para cancelar a edição de pessoa */
    bntCancelar.addEventListener('click', function (e) {
        //limpando os campos
        document.getElementById('id').value = '';
        document.getElementById('nome').value = '';
        document.getElementById('sobrenome').value = '';
        document.getElementById('email').value = '';
        document.getElementById('idade').value = '';
        //habilitando o botão cadastrar
        bntCadastrar.style.display = 'block';
        //desabilitando o botão salvar e cancelar
        bntSalvar.style.display = 'none';
        bntCancelar.style.display = 'none';
    });

    /* Adicionar evento de click na lista depessoas, e caso seja elemento clicado seja bntEdit, 
    é feita carga dos dados da linha para campos input*/
    document.getElementById('listaPessoas').addEventListener('click', function (e) {
        //Recupera o elemento pai do elemento clicado, no caso a linha da tabela tr
        let tr = e.target.parentElement.parentElement;
        //recupera os valores da tabela atraves da classe do elemento 
        let id = tr.querySelector('.id').textContent;
        let nome = tr.querySelector('.nome').textContent;
        let sobrenome = tr.querySelector('.sobrenome').textContent;
        let email = tr.querySelector('.email').textContent;
        let idade = tr.querySelector('.idade').textContent;

        if (e.target.className == 'bntEdit') {
            //recuperando referencias dos inputs e depois 
            let idInput = document.getElementById('id');
            let nomeInput = document.getElementById('nome');
            let sobrenomeInput = document.getElementById('sobrenome');
            let emailInput = document.getElementById('email');
            let idadeInput = document.getElementById('idade');
            //atribuindo valores do conteudo das 
            
            idInput.value = id;
            nomeInput.value = nome;
            sobrenomeInput.value = sobrenome;
            emailInput.value = email;
            idadeInput.value = idade;
            //desabilitando o botão cadastrar
            bntCadastrar.style.display = 'none';
            //habilitando o botão salvar e cancelar
            bntSalvar.style.display = 'block';
            bntCancelar.style.display = 'block';

        }
    });

    // Chamar a função para listar pessoas ao carregar a página
    fetchListasPessoas();

});
