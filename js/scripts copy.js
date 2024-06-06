$(document).ready(function() {
    function carregarMesasAbertas() {
        $.ajax({
            url: "php/obter_mesas.php",
            method: "GET",
            success: function(data) {
                var mesas = JSON.parse(data);
                var mesasHtml = "";
                mesas.forEach(function(mesa) {
                    mesasHtml += `<div class="col-md-2 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"><a href="mesa.html?mesa_id=${mesa.id}">Mesa ${mesa.nome}</a></h5>
                                        </div>
                                    </div>
                                  </div>`;
                });
                $("#mesas-abertas").html(mesasHtml);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    carregarMesasAbertas();

    $("#criar-mesa").click(function() {
        var mesa = $("#nova-mesa").val().trim();
        if (mesa !== "") {
            $.ajax({
                url: "php/criar_mesa.php",
                method: "POST",
                data: { mesa: mesa },
                success: function() {
                    carregarMesasAbertas();
                    $("#nova-mesa").val('');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });

    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    function carregarDetalhesMesa() {
        var mesa_id = getUrlParameter('mesa_id');
        $.ajax({
            url: "php/obter_detalhes_mesa.php",
            method: "POST",
            data: { mesa_id: mesa_id },
            success: function(data) {
                var detalhesMesa = JSON.parse(data);
                var produtosHtml = "";
                var valorTotal = 0;

                detalhesMesa.forEach(function(pedido) {
                    var valorItem = pedido.valor * pedido.quantidade;
                    produtosHtml += `<div class="card mt-2">
                                        <div class="card-body">
                                            <h5 class="card-title">${pedido.produto}</h5>
                                            <p class="card-text">Quantidade: ${pedido.quantidade}</p>
                                            <p class="card-text">Descrição: ${pedido.descricao}</p>
                                            <p class="card-text">Valor: ${valorItem.toFixed(2)}</p>
                                        </div>
                                    </div>`;
                    valorTotal += valorItem;
                });

                $("#produtos-lancados").html(produtosHtml);
                $("#valor-total").html(`<h4>Valor Total: ${valorTotal.toFixed(2)}</h4>`);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    if (window.location.pathname.endsWith('mesa.html')) {
        carregarDetalhesMesa();

        $("#form-adicionar-produto").submit(function(event) {
            event.preventDefault();

            var mesa_id = getUrlParameter('mesa_id');
            var produto = $("#produto").val().trim();
            var quantidade = $("#quantidade").val().trim();
            var descricao = $("#descricao").val().trim();

            if (produto !== "" && quantidade !== "") {
                $.ajax({
                    url: "php/adicionar_produto.php",
                    method: "POST",
                    data: {
                        mesa_id: mesa_id,
                        produto: produto,
                        quantidade: quantidade,
                        descricao: descricao
                    },
                    success: function(response) {
                        alert(response);
                        carregarDetalhesMesa();
                        $("#produto").val('');
                        $("#quantidade").val('');
                        $("#descricao").val('');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });

        $("#excluir-mesa").click(function() {
            var mesa_id = getUrlParameter('mesa_id');
            var salvarVenda = $("#salvar-venda").is(':checked');

            $.ajax({
                url: "php/excluir_mesa.php",
                method: "POST",
                data: { mesa_id: mesa_id, salvar_venda: salvarVenda },
                success: function(response) {
                    alert(response);
                    window.location.href = "index.html";
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        $("#voltar").click(function() {
            window.history.back();
        });
    }

    function fetchMesas() {
        $.ajax({
            url: 'fetch_mesas.php',
            method: 'GET',
            success: function (data) {
                $('#mesasContainer').html(data);
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
});
