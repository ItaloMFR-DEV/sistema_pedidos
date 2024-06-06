function fetchMesas() {
    $.ajax({
        url: 'fetch_mesas.php',
        method: 'GET',
        success: function (data) {
            $('#mesasContainer').html(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Erro ao carregar mesas:', textStatus, errorThrown);
        }
    });
}

function criarMesa(mesaNome) {
    $.ajax({
        url: 'criar_mesa.php',
        method: 'POST',
        data: { nome: mesaNome },
        success: function (response) {
            alert(response);
            fetchMesas();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Erro ao criar mesa:', textStatus, errorThrown);
        }
    });
}


function fetchTotalVendas() {
    $.ajax({
        url: 'fetch_total_vendas.php',
        method: 'GET',
        success: function (data) {
            $('#totalVendas').text(data);
        }
    });
}

function cadastrarProduto() {
    const nome = $('#produtoNome').val();
    const categoria = $('#produtoCategoria').val();
    const subcategoria = $('#produtoSubcategoria').val();
    const valor = $('#produtoValor').val();

    $.ajax({
        url: 'cadastrar_produto.php',
        method: 'POST',
        data: { nome: nome, categoria: categoria, subcategoria: subcategoria, valor: valor },
        success: function (response) {
            alert(response);
            $('#cadastroProdutoForm')[0].reset();
        }
    });
}

function excluirProduto() {
    const nome = $('#produtoNomeExcluir').val();

    $.ajax({
        url: 'excluir_produto.php',
        method: 'POST',
        data: { nome: nome },
        success: function (response) {
            alert(response);
            $('#excluirProdutoForm')[0].reset();
        }
    });
}

function fetchProdutosMesa(mesaId) {
    $.ajax({
        url: 'fetch_produtos_mesa.php',
        method: 'GET',
        data: { mesa_id: mesaId },
        success: function (data) {
            $('#produtosContainer').html(data);
        }
    });
}

function adicionarProduto(mesaId, produto, quantidade, descricao) {
    $.ajax({
        url: 'adicionar_produto.php',
        method: 'POST',
        data: { mesa_id: mesaId, produto: produto, quantidade: quantidade, descricao: descricao },
        success: function (response) {
            alert(response);
            fetchProdutosMesa(mesaId);
        }
    });
}

function excluirMesa(mesaId, salvarVenda) {
    $.ajax({
        url: 'excluir_mesa.php',
        method: 'POST',
        data: { mesa_id: mesaId, salvar_venda: salvarVenda },
        success: function (response) {
            alert(response);
            window.location.href = 'index.html';
        }
    });
}
