// JavaScript Document



function marcardesmarcar() {
    if ($("#TodosOsCheckBox").attr("checked")) {
        $('.marcar').each(
            function() {
                $(this).attr("checked", true);
            }
            );
    } else {
        $('.marcar').each(
            function() {
                $(this).attr("checked", false);
            }
            );
    }
}



function EnviaIdsParaHidden(origem, Id, destino) {
    if (origem.checked == true) {
        document.getElementById(destino).value = document.getElementById(destino).value.replace(Id + ', ', '') + Id + ', ';
    } else {
        document.getElementById(destino).value = document.getElementById(destino).value.replace(Id + ', ', '');
    }
}


function marcaComoPago() {
    if ($('#id_forma_pagamento').val() != '' &&
        $('#id_conta').val() != '' &&
        $('#pago').val() != 'S' &&
        $('#conciliado').is(':checked')) {
        if (confirm('Deseja marcar esta conta como paga?')) {
            $('#pago').find('option[value="S"]').attr('selected', true);
        }
    }
}



function requestingPopupPermission(callback) {
    window.webkitNotifications.requestPermission(callback);
}

function showPopup() {
    if (window.webkitNotifications.checkPermission() > 0) {
        requestingPopupPermission(showPopup);
    }
}



function getScrollSize() {
    this.maxY = 'scrollMaxY' in window ? window.scrollMaxY : document.getElementsByTagName("body")[0].scrollHeight - document.getElementsByTagName("body")[0].clientHeight;
    this.maxX = 'scrollMaxX' in window ? window.scrollMaxX : document.getElementsByTagName("body")[0].scrollWidth - document.getElementsByTagName("body")[0].clientWidth;
    return true;
}


function autoScroll(tempo, to) {
    // alert(document.getElementsByTagName("body")[0].style.maxHeight);
    if (window.pageYOffset < to) {
        scrollInterval(((window.pageYOffset + to) / (tempo / 25)), 1, to);
    } else {
        scrollInterval(((window.pageYOffset - to) / (tempo / 25)), 0, to);
    }
    return true;
}

function scrollInterval(y, baixo, max) {

    if (baixo && window.pageYOffset < max) {
        setTimeout(function() {
            scrollInterval(y, baixo, max);
        }, 25);

        scrollTo(0, window.pageYOffset + y);
    }

    if (!baixo && window.pageYOffset > max) {
        setTimeout(function() {
            scrollInterval(y, baixo, max);
        }, 25);

        scrollTo(0, window.pageYOffset - y);
    }

    return true;

}




function valorCalculavel(valor) {

    if (valor == '' || valor == null) {
        valor = 'R$ 0,00';
    }

    valor = valor.replace('U$ ', '');
    valor = valor.replace('R$ ', '');
    valor = valor.replace('.', '');
    valor = valor.replace(',', '.');
    return(parseFloat(valor));
}





function calcTotalParcelas() {

    vcampo = document.getElementById('valor').value;
    v1 = vcampo.replace(".", "");
    v2 = v1.replace(",", ".");
    var vCampo = parseFloat(v2.replace("R$ ", ""));

    var parcelas = parseFloat(document.getElementById('parcelas').value);
    if (parcelas > 0) {
        document.getElementById('txtTotalParcelas').style.display = 'inline';
        document.getElementById('totalParcelas').style.display = 'inline';
        document.getElementById('totalParcelas').value = number_format(vCampo * parcelas, 2, ',', '.');
    } else {
        document.getElementById('txtTotalParcelas').style.display = 'none';
        document.getElementById('totalParcelas').style.display = 'none';
    }
}

function loopSelected(campoSelect, campoValores) {

    var txtSelectedValuesObj = campoValores;
    var selectedArray = new Array();
    var selObj = campoSelect;
    var i;
    var count = 0;
    for (i = 0; i < selObj.options.length; i++) {
        if (selObj.options[i].selected) {
            selectedArray[count] = selObj.options[i].value;
            count++;
        }
    }
    txtSelectedValuesObj.value = selectedArray;
}



function rand(l, u) {
    return Math.floor((Math.random() * (u - l + 1)) + l);
}


varExiste = function(x)
{
    if ((x == 'undefined') || (x == null)) {
        return true;
    }
    else {
        return false;
    }

};



function textCounter(field, countfield, maxlimit) {
    if (field.value.length > maxlimit)
        field.value = field.value.substring(0, maxlimit);
    else
        countfield.value = maxlimit - field.value.length;
    alert('M�ximo ' + maxlimit + ' caracteres.');
}




function isValidCreditCardNumber(cardNumber, cardType) {
    var isValid = false;
    var ccCheckRegExp = /[^\d ]/;
    isValid = !ccCheckRegExp.test(cardNumber);
    if (isValid) {
        var cardNumbersOnly = cardNumber.replace(/ /g, "");
        var cardNumberLength = cardNumbersOnly.length;
        var lengthIsValid = false;
        var prefixIsValid = false;
        var prefixRegExp;
        switch (cardType) {
            case "mastercard":
                lengthIsValid = (cardNumberLength == 16);
                prefixRegExp = /^5[1-5]/;
                break;
            case "visa":
                lengthIsValid = (cardNumberLength == 16 || cardNumberLength == 13);
                prefixRegExp = /^4/;
                break;
            case "amex":
                lengthIsValid = (cardNumberLength == 15);
                prefixRegExp = /^3(4|7)/;
                break;
            default:
                prefixRegExp = /^$/;
                alert("Tipo de cartao nao encontrado.");
                return false;
        }

        prefixIsValid = prefixRegExp.test(cardNumbersOnly);
        isValid = prefixIsValid && lengthIsValid;
    }
    if (isValid) {
        var numberProduct;
        var numberProductDigitIndex;
        var checkSumTotal = 0;
        for (digitCounter = cardNumberLength - 1; digitCounter >= 0; digitCounter--) {
            checkSumTotal += parseInt(cardNumbersOnly.charAt(digitCounter));
            digitCounter--;
            numberProduct = String((cardNumbersOnly.charAt(digitCounter) * 2));
            for (var productDigitCounter = 0; productDigitCounter < numberProduct.length; productDigitCounter++) {
                checkSumTotal += parseInt(numberProduct.charAt(productDigitCounter));
            }
        }
        isValid = (checkSumTotal % 10 == 0);
    }

    return isValid;
}



function verificaCartao(numero, bandeira) {
    if (isValidCreditCardNumber(numero, bandeira) == true) {
        document.getElementById('cod').focus();
    } else {
        // document.getElementById('numero').focus();
        alert('O numero digitado nao corresponde a um cartao ' + bandeira + ' valido.');
    }
}



function selecionarSelect(Valor, combo) {
    for (var i = 0; i < combo.options.length; i++)
    {
        if (combo.options[i].value == Valor)
        {
            combo.options[i].selected = "true";
            break;
        }
    }
}

function menusPDV(n, qtd) {
    for (x = 1; x <= qtd; x++) {
        //alert(x);
        panel = eval(document.getElementById('menu_' + x).style);
        if (x == n) {
            panel.display = '';
        }
        else {
            panel.display = '';
        }
    }
} //-->




function somaServicos(Tipo, obj, valor) {

    vcampo = document.getElementById('totalServico').value;
    v1 = vcampo.replace(".", "");
    vAtual = v1.replace(",", ".");

    vcampoReserva = document.getElementById('total_taxas').value;
    v1Reserva = vcampoReserva.replace(".", "");
    vAtualReserva = v1Reserva.replace(",", ".");

    if (Tipo == 'soma') {
        obj.value = parseFloat(obj.value) + 1;
        //document.getElementById('totalServico').value=number_format(parseFloat(vAtual)+parseFloat(valor),2,',','.');
        document.getElementById('total_taxas').value = number_format(parseFloat(valor) + parseFloat(vAtualReserva), 2, ',', '.');
    } else {

        /// subtrai
        if (parseFloat(obj.value) > 0) {
            obj.value = parseFloat(obj.value) - 1;
            //document.getElementById('totalServico').value=number_format(parseFloat(vAtual)-parseFloat(valor),2,',','.');
            document.getElementById('total_taxas').value = number_format(parseFloat(vAtualReserva) - parseFloat(valor), 2, ',', '.');
        }
    }
}




function calculaConciliacaoBancaria(campoCredito, vCredito, Id) {

    vcampo = document.getElementById('totalSelecao').value;
    v1 = vcampo.replace(".", "");
    vAtual = v1.replace(",", ".");

    if (vAtual == '') {
        vAtual = 0;
    }

    if (campoCredito == true) {
        document.getElementById('totalSelecao').value = number_format(parseFloat(vAtual) + parseFloat(vCredito), 2, ',', '.');
        document.getElementById('idsSelecao').value = document.getElementById('idsSelecao').value.replace(Id + ', ', '') + Id + ', ';
    } else {
        document.getElementById('totalSelecao').value = number_format(parseFloat(vAtual) - parseFloat(vCredito), 2, ',', '.');
        document.getElementById('idsSelecao').value = document.getElementById('idsSelecao').value.replace(Id + ', ', '');
    }

    verificaValorConcilia();
}

function verificaValorConcilia() {
    if (document.getElementById('totalSelecao').value == document.getElementById('totalBanco').value) {
        // se for o mesmo valor ja joga na concilia��o
        if (confirm("Tem certeza que deseja conciliar esta conta?")) {
            /// abre iframe com os dados
            document.getElementById('envia').src = 'sql-conciliacao.php?acao=concilia&referente_arquivo=' + document.getElementById('referente_arquivo').value + '&idBanco=' + document.getElementById('idBanco').value + '&idsSelecao=' + document.getElementById('idsSelecao').value + '&contaBanco=' + document.getElementById('contaBanco').value;
        }
    }
}



/// calcula dias///
function numdias(mes, ano) {
    if ((mes < 8 && mes % 2 == 1) || (mes > 7 && mes % 2 == 0))
        return 31;
    if (mes != 2)
        return 30;
    if (ano % 4 == 0)
        return 29;
    return 28;
}
///
function somadias(data, dias) {
    data = data.split('/');
    diafuturo = parseInt(data[0]) + dias;
    mes = parseInt(data[1]);
    ano = parseInt(data[2]);
    while (diafuturo > numdias(mes, ano)) {
        diafuturo -= numdias(mes, ano);
        mes++;
        if (mes > 12) {
            mes = 1;
            ano++;
        }
    }

    if (diafuturo < 10)
        diafuturo = '0' + diafuturo;
    if (mes < 10)
        mes = '0' + mes;

    return diafuturo + "/" + mes + "/" + ano;
}
////// fim calcula dia.


function filtraEstoqueStatus(Tipo) {
    AtualizaJanela('dados-estoque.php?filtraTipo=' + Tipo, 'Transacoes');
}


function filtraEstoqueStatusPDV(Tipo) {
    AtualizaJanela('dados-estoque-pdv.php?filtraTipo=' + Tipo, 'Transacoes');
}


function mostraHistorico(reservaHistorico, numCliente) {
    // diminui tamanho do cad. clientes
    document.getElementById('linkAltCliente_' + numCliente).style.width = '195px';
    document.getElementById('linkAltCliente_' + numCliente).style.paddingTop = '4px';
    document.getElementById('linkAltCliente_' + numCliente).style.height = '16px';
    document.getElementById('linkAltCliente_' + numCliente).style.cssFloat = 'left';

    // bota historico
    document.getElementById('txtHistorico').style.display = '';

    /// bota valor da reserva que vai abrir
    document.getElementById('reservaHistorico').value = reservaHistorico;

    if (reservaHistorico == '') {
        document.getElementById('txtHistorico').style.display = 'none';
    }
}


/// concilia
function concilia(contaBanco, contaSis, valorBanco, valorSis, tipoBanco, tipoSis) {
    if (confirm("Tem certeza que deseja conciliar esta conta?")) {
        document.getElementById('envia').src = 'sql-checkin-checkout.php?acao=lancaPagamento&valor=' + valor + '&reserva=' + reserva + '&codigo=' + codigo + ' &text_fPag=' + text_fPag + '&id_fPag' + id_fPag + '&aba' + aba;
    }
}




function abreAdd(div, campo1) {
    document.getElementById(div).style.display = 'inline';
    document.getElementById(campo1).focus();
}


function ResetaContasBanco() {
    for (var i = 0; i < document.formContasBanco.elements.length; i++) {
        document.formContasBanco.elements[i].checked = false;
    }
}



function alterarUH(ClasseAtual, ClasseNova, Ap, Reserva) {
    if (ClasseAtual == ClasseNova) {
        parent.document.getElementById('enviaUH').src = 'sql-uhs.php?acao=mudauh&reserva=' + Reserva + '&ap=' + Ap;
    } else {
        document.getElementById('editarUH_' + Ap).style.display = 'inline';
    }
}


function validaCheckOut(IdAp, Reserva) {
    /// check op��es....

    if (document.getElementById('totalDiariasPendente').value > 0.0) {
        alert('N�o � poss�vel realizar o check out, existe um saldo devedor de R$ ' + document.getElementById('totalDiariasPendente').value + ' na aba de di�rias.');
        return false;
    }

    if (document.getElementById('chaves').checked == true && document.getElementById('frigobar').checked == true && document.getElementById('feedback').checked == true && document.getElementById('emprestimos').checked == true) {
        var CheckOpcoes = "ok";
    } else {
        alert("Verifique os itens do Check Out");
        return false;
    }

    /// verifica se o saldo ta zerado
    if ((parseInt(document.getElementById('saldo').value) == 0 || parseInt(document.getElementById('saldo').value) == -1 || document.getElementById('saldo').value == '0,00') && CheckOpcoes == 'ok') {
        if (document.getElementById('desconto').value != '') {
            document.getElementById('JanelaDesconto').style.display = 'inline';
        } else {

            // bloqueio bot�o pra evitar que cliquem de novo.
            document.getElementById('darCheckOut').innerHTML = '<marquee onMouseOver="this.stop();" onMouseOut="this.start();" scrolldelay="0" scrollamount="3">Aguarde... Enviando Solicita��o...</marquee>';

            /// envia p�gina e da check out
            document.getElementById('envia').src = 'sql-checkin-checkout.php?checkOutDireto=S&id_apartamento=' + IdAp + '&reserva=' + Reserva + '&janela=' + document.getElementById('janela').value;
        }
    } else {
        alert('Faltam R$ ' + number_format(document.getElementById('saldo').value, 2, ',', '.'));
    }

}

function calcCheckOut(TotalAtual) {

    vDigitado = document.getElementById('credito').value;
    v1 = vDigitado.replace(".", "");
    vFormatado = v1.replace(",", ".");
    if (vFormatado == '') {
        vFormatado = 0;
    }

    vDigitadoDesconto = document.getElementById('desconto').value;
    v1Desconto = vDigitadoDesconto.replace(".", "");
    vFormatadoDesconto = v1Desconto.replace(",", ".");
    if (vFormatadoDesconto == '') {
        vFormatadoDesconto = 0;
    }

    document.getElementById('totalGeralcheckout').innerHTML = number_format(parseFloat(TotalAtual) - parseFloat(vFormatado) - parseFloat(vFormatadoDesconto), 2, ',', '.');
    document.getElementById('saldo').value = parseFloat(TotalAtual) - parseFloat(vFormatado) - parseFloat(vFormatadoDesconto);
}


function qtd(Tipo, obj) {
    if (Tipo == 'soma') {
        obj.value = parseFloat(obj.value) + 1;
    } else {

        /// subtrai
        if (parseFloat(obj.value) > 0) {
            obj.value = parseFloat(obj.value) - 1;
        }
    }
}


function atualizarCriancas() {
    if (document.getElementById('clicouCalendario').value == 'S') {

        MudaPeriodo('inc-aps-periodo.php?periodo1=' + document.getElementById('periodo').value.substr(0, 10) + '&periodo2=' + document.getElementById('periodo').value.substr(20) + '&adultos=' + document.getElementById('adultos').options[document.getElementById('adultos').selectedIndex].value + '&bebes=' + document.getElementById('bebes').options[document.getElementById('bebes').selectedIndex].value + '&criancas=' + document.getElementById('criancas').options[document.getElementById('criancas').selectedIndex].value + '&allotment=' + document.getElementById('allotment').value);

        ocultaCalendario();

    }
}

function escolheTema(tipo, imgtema) {
    if (tipo == 'over') {
        document.getElementById(imgtema).style.border = '#ffa18b solid 3px';
    } else {
        document.getElementById(imgtema).style.border = '';
    }
}


function novaReservaViaMapa(cor, idAp, periodoClicado, reserva_mista) {

    /// inverte data para vericar se � mais baixo.
    var periodo1Clique = document.getElementById('reservaP1').value.substr(6, 4);
    var periodo1Clique = periodo1Clique + '-' + document.getElementById('reservaP1').value.substr(3, 2);
    var periodo1Clique = periodo1Clique + '-' + document.getElementById('reservaP1').value.substr(0, 2);

    var periodoClicadoUS = periodoClicado.substr(6, 4);
    var periodoClicadoUS = periodoClicadoUS + '-' + periodoClicado.substr(3, 2);
    var periodoClicadoUS = periodoClicadoUS + '-' + periodoClicado.substr(0, 2);

    /// verifica se mascou menor que periodo 1.
    if (periodoClicadoUS < periodo1Clique) {
        return false;
    }

    /// verifica se � o mesmo dia.
    if (periodoClicado == document.getElementById('reservaP1').value) {
        return false;
    }

    periodo1 = document.getElementById('reservaP1').value;
    cor.style.background = '#0088b5';

    periodo2 = document.getElementById('reservaP2').value;
    cor.style.background = '#0088b5';

    periodo3 = document.getElementById('reservaP3').value;
    cor.style.background = '#0088b5';

    if (reserva_mista == 'ok') {
        if (periodo1 != '' && periodo2 != '' && periodo3 != '') {
            AbreJanela('altera-reserva.php?tipo=nova&reserva_mista=ok&idAp=' + document.getElementById('id_ap1').value + '&idAp2=' + idAp + '&periodo1=' + periodo1 + '&periodo2=' + periodo2 + '&periodo3=' + document.getElementById('reservaP2').value + '&periodo4=' + periodoClicado, 'Nova Reserva');
        } else {

            /// defini periodos
            if (periodo1 == '') {
                document.getElementById('reservaP1').value = periodoClicado;
                document.getElementById('id_ap1').value = idAp;
            }

            if (periodo1 != '' && periodo2 == '') {
                document.getElementById('reservaP2').value = periodoClicado;
            }
            if (periodo1 != '' && periodo2 != '' && periodo3 == '') {
                document.getElementById('reservaP3').value = periodoClicado;
            }
        }
    //// fim reservas mista

    } else {
        /// resrevas simples
        if (periodo1 != '') {
            AbreJanela('altera-reserva.php?tipo=nova&idAp=' + idAp + '&periodo1=' + periodo1 + '&periodo2=' + periodoClicado, 'Nova Reserva')
        } else {
            document.getElementById('reservaP1').value = periodoClicado;
        }
    } //// fim reserva simples

}


function alteraApReserva(DescAp, idAp, reserva, Tarifa) {

}




function dadosAlteraPeriodo(periodo1, periodo2, reserva, tipo, idAp, qtdAdultos, qtdCriancas, id_cliente, nomeCliente) {

    if (periodo1 == null || periodo2 == null) {
        return false;
    }

    AbreReserva('altera-reserva.php?acao=alteraPeriodo&recalcula=S&id=' + reserva + '&periodo1=' + periodo1 + '&periodo2=' + periodo2 + '&tipo=' + tipo + '&idAp=' + idAp + '&qtdAdultos=' + qtdAdultos + '&qtdCriancas=' + qtdCriancas + '&id_cliente=' + id_cliente + '&nomeCliente=' + encodeURI(nomeCliente));
    // fecha janela
    document.getElementById('AlteraPeriodo').style.display = 'none';
}



function setasMapaOcupacao(obj, efeito, acao, pagina) {

    var browser = navigator.appName;
    /// verifica efeito
    if (efeito == 'over') {
        obj.style.MozOpacity = 0.83;
        if (navigator.appName == "Microsoft Internet Explorer") {
            obj.filters.alpha.opacity = 83;
        }
    } else {
        obj.style.MozOpacity = 0.25;
        if (navigator.appName == "Microsoft Internet Explorer") {
            obj.filters.alpha.opacity = 25;
        }
    }

    // verifica se tem a��o
    if (acao == 'passa1') {
        MudaPagina(pagina);
    }

    if (acao == 'passaPagina') {
        MudaPagina(pagina);
    }
}



function msgComum(tipo) {
    /// abri o colorbox
    $(document).ready(function() {
        $.fn.colorbox({
            href: '#msg', 
            inline: true, 
            open: true
        });
    });

    if (tipo == 'reserva') {
        MudaPagina('add-reserva.php')
    }
}

function abrePgColorbox(pagina) {
    /// abri o colorbox
    $(document).ready(function() {
        $.fn.colorbox({
            href: pagina, 
            inline: false, 
            open: true
        });
    });
}



function ColorboxAddContas(pagina) {
    /// abri o colorbox
    $(document).ready(function() {
        $.fn.colorbox({
            href: pagina, 
            width: "700", 
            inline: false, 
            open: true, 
            height: "420", 
            iframe: true
        });
    });
}

function ColorboxAddEstoque(pagina) {
    /// abri o colorbox
    $(document).ready(function() {
        $.fn.colorbox({
            href: pagina, 
            width: "850", 
            inline: false, 
            open: true, 
            height: "360", 
            iframe: true
        });
    });
}


function abrePgColorboxFrameMensagem(pagina) {
    /// abri o colorbox
    $(document).ready(function() {
        $.fn.colorbox({
            href: pagina, 
            width: "800", 
            inline: false, 
            open: true, 
            height: "500", 
            iframe: true
        });
    });
}


function erroLogin() {
    /// abri o colorbox
    $(document).ready(function() {
        $.fn.colorbox({
            href: '#msg_login_existe', 
            inline: true, 
            open: true
        });
    });
    document.getElementById('Loading').innerHTML = '';
}

function selecionaTodosAcessos(form1) {
    for (var i = 0; i < form1.elements.length; i++) {
        if (form1.elements[i].type == 'checkbox' && form1.elements[i].name != 'segunda' && form1.elements[i].name != 'terca' && form1.elements[i].name != 'quarta' && form1.elements[i].name != 'quinta' && form1.elements[i].name != 'sexta' && form1.elements[i].name != 'sabado' && form1.elements[i].name != 'domingo') {
            form1.elements[i].checked = form1.todos.checked;
        }
    }
}




function TiraTodosChecks(form) {
    for (var i = 0; i < form.elements.length; i++) {
        if (form.elements[i].type == 'checkbox') {
            form.elements[i].checked = false;
        }
    }
}




function selecionaTodos(form1) {
    for (var i = 0; i < form1.elements.length; i++) {
        if (form1.elements[i].type == 'checkbox') {
            form1.elements[i].checked = form1.todos.checked;
        }
    }
}


function AtivaTodos(form1) {
    for (var i = 0; i < form1.elements.length; i++) {
        if (form1.elements[i].type == 'radio') {
            form1.elements[i].disabled = false;
        }
    }
}


function mostraMiniPOP(janela) {
    document.getElementById(janela).style.display = 'inline';
}

function ocultaMiniPOP(janela) {
    document.getElementById(janela).style.display = 'none';
}


function retiraCheksServicos() {
    for (var i = 0; i < document.formreserva.elements.length; i++) {
        if (document.formreserva.elements[i].type == 'checkbox') {
            document.formreserva.elements[i].checked = false;
        }
    }
}

function ocultaRmClasses() {
    document.getElementById('tr1').style.display = 'none';
    document.getElementById('tr2').style.display = 'none';
    document.getElementById('tr5').style.display = 'none';
    document.getElementById('tr6').style.display = 'none';
}

function mostraRmClasses() {
    document.getElementById('tr1').style.display = '';
    document.getElementById('tr2').style.display = '';
    document.getElementById('tr5').style.display = '';
    document.getElementById('tr6').style.display = '';
}

function calculaBaixaTemporada() {
    vDigitado = document.getElementById('tarifa_de_baixa_temp').value;
    v1 = vDigitado.replace(".", "");
    vFormatado = v1.replace(",", ".");

    document.getElementById('BTarifa1').innerHTML = number_format(parseFloat(vFormatado) - (parseFloat(vFormatado) / 100) * 15, 2, ',', '.');
    document.getElementById('BTarifa2').innerHTML = number_format((parseFloat(vFormatado) / 100) * 20 + parseFloat(vFormatado), 2, ',', '.');
}

function calculaMediaTemporada() {
    vDigitado = document.getElementById('tarifa_de_media_temp').value;
    v1 = vDigitado.replace(".", "");
    vFormatado = v1.replace(",", ".");

    document.getElementById('MTarifa1').innerHTML = number_format(parseFloat(vFormatado) - (parseFloat(vFormatado) / 100) * 15, 2, ',', '.');
    document.getElementById('MTarifa2').innerHTML = number_format((parseFloat(vFormatado) / 100) * 20 + parseFloat(vFormatado), 2, ',', '.');
}

function calculaAltaTemporada() {
    vDigitado = document.getElementById('tarifa_de_alta_temp').value;
    v1 = vDigitado.replace(".", "");
    vFormatado = v1.replace(",", ".");

    document.getElementById('ATarifa1').innerHTML = number_format(parseFloat(vFormatado) - (parseFloat(vFormatado) / 100) * 15, 2, ',', '.');
    document.getElementById('ATarifa2').innerHTML = number_format((parseFloat(vFormatado) / 100) * 20 + parseFloat(vFormatado), 2, ',', '.');
}

function calculaTarifaNormal() {
    vDigitado = document.getElementById('tarifa_normal_minimo').value;
    v1 = vDigitado.replace(".", "");
    vFormatado = v1.replace(",", ".");

    document.getElementById('NTarifa1').innerHTML = number_format(parseFloat(vFormatado) - (parseFloat(vFormatado) / 100) * 15, 2, ',', '.');
    document.getElementById('NTarifa2').innerHTML = number_format(parseFloat(vFormatado) + (parseFloat(vFormatado) / 100) * 20, 2, ',', '.');
}

function calculaBaixaTemporadaFDS() {
    vDigitado = document.getElementById('tarifa_de_baixa_temp_fds').value;
    v1 = vDigitado.replace(".", "");
    vFormatado = v1.replace(",", ".");

    document.getElementById('BTarifa5').innerHTML = number_format(parseFloat(vFormatado) - (parseFloat(vFormatado) / 100) * 15, 2, ',', '.');
    document.getElementById('BTarifa6').innerHTML = number_format(parseFloat(vFormatado) + (parseFloat(vFormatado) / 100) * 20, 2, ',', '.');
}

function calculaMediaTemporadaFDS() {
    vDigitado = document.getElementById('tarifa_de_media_temp_fds').value;
    v1 = vDigitado.replace(".", "");
    vFormatado = v1.replace(",", ".");

    document.getElementById('MTarifa5').innerHTML = number_format(parseFloat(vFormatado) - (parseFloat(vFormatado) / 100) * 15, 2, ',', '.');
    document.getElementById('MTarifa6').innerHTML = number_format(parseFloat(vFormatado) + (parseFloat(vFormatado) / 100) * 20, 2, ',', '.');
}

function calculaAltaTemporadaFDS() {
    vDigitado = document.getElementById('tarifa_de_alta_temp_fds').value;
    v1 = vDigitado.replace(".", "");
    vFormatado = v1.replace(",", ".");

    document.getElementById('ATarifa5').innerHTML = number_format(parseFloat(vFormatado) - (parseFloat(vFormatado) / 100) * 15, 2, ',', '.');
    document.getElementById('ATarifa6').innerHTML = number_format(parseFloat(vFormatado) + (parseFloat(vFormatado) / 100) * 20, 2, ',', '.');
}

function calculaTarifaNormalFDS() {
    vDigitado = document.getElementById('tarifa_normal_fds').value;
    v1 = vDigitado.replace(".", "");
    vFormatado = v1.replace(",", ".");

    document.getElementById('NTarifa5').innerHTML = number_format(parseFloat(vFormatado) - (parseFloat(vFormatado) / 100) * 15, 2, ',', '.');
    document.getElementById('NTarifa6').innerHTML = number_format(parseFloat(vFormatado) + (parseFloat(vFormatado) / 100) * 20, 2, ',', '.');
}

function fechadJanelaClientes() {
    document.getElementById('addregistro').style.display = 'none';
    document.getElementById('Loadingformclientes').style.display = 'none';
}

function EfeitoValor() {  // efeito-jquery.js
    $(document).ready(function() {
        $(".campovalor").effect("highlight", {}, 1000);
    });
}

function number_format(number, decimals, dec_point, thousands_sep) {
    var n = number, prec = decimals;

    var toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return (Math.round(n * k) / k).toString();
    };

    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
    var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;

    var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;
    var abs = toFixedFix(Math.abs(n), prec);
    var _, i;

    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;

        _[0] = s.slice(0, i + (n < 0)) +
        _[0].slice(i).replace(/(\d{3})/g, sep + '$1');
        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }

    var decPos = s.indexOf(dec);
    if (prec >= 1 && decPos !== -1 && (s.length - decPos - 1) < prec) {
        s += new Array(prec - (s.length - decPos - 1)).join(0) + '0';
    }

    else if (prec >= 1 && decPos === -1) {
        s += dec + new Array(prec).join(0) + '0';
    }
    return s;
}


function calculaReserva(campoServico, vServico) {

    vcampo = document.getElementById('valor').value;
    v1 = vcampo.replace(".", "");
    vAtual = v1.replace(",", ".");

    vcampoServicos = document.getElementById('taxa_servico').value;
    v1Servicos = vcampoServicos.replace(".", "");
    vAtualServicos = v1Servicos.replace(",", ".");

    if (campoServico == true) {
        document.getElementById('valor').value = number_format(parseFloat(vAtual) + parseFloat(vServico), 2, ',', '.');
        document.getElementById('totalParaCalc').value = number_format(parseFloat(vAtual) + parseFloat(vServico), 2, ',', '.');
        document.getElementById('total_taxas').value = number_format(parseFloat(vAtual) + parseFloat(vServico) + parseFloat(vAtualServicos), 2, ',', '.');
    } else {
        document.getElementById('valor').value = number_format(parseFloat(vAtual) - parseFloat(vServico), 2, ',', '.');
        document.getElementById('totalParaCalc').value = number_format(parseFloat(vAtual) - parseFloat(vServico), 2, ',', '.');
        document.getElementById('total_taxas').value = number_format(parseFloat(vAtual) - parseFloat(vServico) + parseFloat(vAtualServicos), 2, ',', '.');
    }

    EfeitoValor();
}




function transacoesBanco(campoBanco, Id) {

    if (campoBanco == true) {
        document.getElementById('idsBancosSelecionados').value = document.getElementById('idsBancosSelecionados').value.replace(Id + ', ', '') + Id + ', ';
    } else {
        document.getElementById('idsBancosSelecionados').value = document.getElementById('idsBancosSelecionados').value.replace(Id + ', ', '');
    }

    loadingCarregandoMapa();
    AtualizaJanela('transacoes.php?acao=ocultaMapa&idsBancosSelecionados=' + encodeURI(document.getElementById('idsBancosSelecionados').value) + '&opcoesSituacao=' + encodeURI(document.getElementById('opcoesSituacaoAtual').value) + '&idsFormaPagSelecionados=' + encodeURI(document.getElementById('idsFormaPagSelecionadosAtual').value) + '&catsSelecionadas=' + encodeURI(document.getElementById('catsSelecionadasAtual').value) + '&deDia=' + document.getElementById('deDia').value + '&ateDia=' + document.getElementById('ateDia').value + '&idsFornecedor=' + encodeURI(document.getElementById('idsFornecedorAtual').value), 'Transacoes');


}




function checkPorSituacao(campoSituacao, Id) {
    if (campoSituacao == true) {
        document.getElementById('opcoesSituacaoAtual').value = document.getElementById('opcoesSituacaoAtual').value.replace(Id + ', ', '') + Id + ', ';
    } else {
        document.getElementById('opcoesSituacaoAtual').value = document.getElementById('opcoesSituacaoAtual').value.replace(Id + ', ', '');
    }
}


function pesquisarFinanceiro() {
    if (document.getElementById('idsBancosSelecionadosAtual').value == '' && document.getElementById('tipoData').value == 'Conciliado') {
        alert('Por favor, selecione uma conta.');
        return false;
    }

    loadingCarregandoMapa();

    obrigaPeriodo = '';
    if (document.getElementById('obrigaPeriodo').value == 'S') {
        obrigaPeriodo = '&obrigaPeriodo=S';
    }

    AtualizaJanela('financeiro/transacoes.php?acao=ocultaMapa&opcoesSituacao=' + encodeURI(document.getElementById('opcoesSituacaoAtual').value) + '&deDia=' + document.getElementById('deDia').value + '&ateDia=' + document.getElementById('ateDia').value + '&idsBancosSelecionados=' + encodeURI(document.getElementById('idsBancosSelecionadosAtual').value) + '&idsFormaPagSelecionados=' + encodeURI(document.getElementById('idsFormaPagSelecionadosAtual').value) + '&idsSetoresSelecionados=' + encodeURI(document.getElementById('idsSetoresSelecionadosAtual').value) + '&catsSelecionadas=' + encodeURI(document.getElementById('catsSelecionadasAtual').value) + '&opcoesTipo=' + encodeURI(document.getElementById('opcoesTipoAtual').value) + '&idsFornecedor=' + encodeURI(document.getElementById('idsFornecedorAtual').value) + '&tipoData=' + encodeURI(document.getElementById('tipoData').value) + '&busca=' + encodeURI(document.getElementById('busca').value) + obrigaPeriodo, 'Transacoes');
}



function transacoesPorFormaPagamento(campoFormaPagamento, Id, mes, ano) {

    if (campoFormaPagamento == true) {
        document.getElementById('idsFormaPagSelecionados').value = document.getElementById('idsFormaPagSelecionados').value.replace(Id + ', ', '') + Id + ', ';
    } else {
        document.getElementById('idsFormaPagSelecionados').value = document.getElementById('idsFormaPagSelecionados').value.replace(Id + ', ', '');
    }

    loadingCarregandoMapa();
    AtualizaJanela('transacoes.php?acao=ocultaMapa&idsFormaPagSelecionados=' + encodeURI(document.getElementById('idsFormaPagSelecionados').value) + '&idsBancosSelecionados=' + encodeURI(document.getElementById('idsBancosSelecionadosAtual').value) + '&opcoesSituacao=' + encodeURI(document.getElementById('opcoesSituacaoAtual').value) + '&idsSetoresSelecionados=' + encodeURI(document.getElementById('idsSetoresSelecionadosAtual').value) + '&catsSelecionadas=' + encodeURI(document.getElementById('catsSelecionadasAtual').value) + '&deDia=' + document.getElementById('deDia').value + '&ateDia=' + document.getElementById('ateDia').value + '&idsFornecedor=' + encodeURI(document.getElementById('idsFornecedorAtual').value), 'Transacoes');


}



function checkTransacoesSetores(campoSetor, Id, mes, ano) {

    if (campoSetor == true) {
        document.getElementById('idsSetoresSelecionados').value = document.getElementById('idsSetoresSelecionados').value.replace(Id + ', ', '') + Id + ', ';
    } else {
        document.getElementById('idsSetoresSelecionados').value = document.getElementById('idsSetoresSelecionados').value.replace(Id + ', ', '');
    }

    loadingCarregandoMapa();

    AtualizaJanela(document.getElementById('retornoPg').value + '.php?acao=ocultaMapa&idsSetoresSelecionados=' + encodeURI(document.getElementById('idsSetoresSelecionados').value) + '&idsBancosSelecionados=' + encodeURI(document.getElementById('idsBancosSelecionadosAtual').value) + '&opcoesSituacao=' + encodeURI(document.getElementById('opcoesSituacaoAtual').value) + '&idsFormaPagSelecionados=' + encodeURI(document.getElementById('idsFormaPagSelecionadosAtual').value) + '&deDia=' + document.getElementById('deDia').value + '&ateDia=' + document.getElementById('ateDia').value + '&idsFornecedor=' + encodeURI(document.getElementById('idsFornecedorAtual').value), 'Transacoes');


}




function checkTransacoesFornecedor(campoSetor, Id) {

    if (campoSetor == true) {
        document.getElementById('idsFornecedor').value = document.getElementById('idsFornecedor').value.replace(Id + ', ', '') + Id + ', ';
    } else {
        document.getElementById('idsFornecedor').value = document.getElementById('idsFornecedor').value.replace(Id + ', ', '');
    }

    loadingCarregandoMapa();

    AtualizaJanela('transacoes.php?acao=ocultaMapa&idsSetoresSelecionados=' + encodeURI(document.getElementById('idsSetoresSelecionadosAtual').value) + '&idsBancosSelecionados=' + encodeURI(document.getElementById('idsBancosSelecionadosAtual').value) + '&opcoesSituacao=' + encodeURI(document.getElementById('opcoesSituacaoAtual').value) + '&idsFormaPagSelecionados=' + encodeURI(document.getElementById('idsFormaPagSelecionadosAtual').value) + '&deDia=' + document.getElementById('deDia').value + '&ateDia=' + document.getElementById('ateDia').value + '&idsFornecedor=' + encodeURI(document.getElementById('idsFornecedor').value), 'Transacoes');


}




function transacoesBancoPDV(campoBanco, Id) {

    if (campoBanco == true) {
        document.getElementById('idsBancosSelecionados').value = document.getElementById('idsBancosSelecionados').value.replace(Id + ', ', '') + Id + ', ';
    } else {
        document.getElementById('idsBancosSelecionados').value = document.getElementById('idsBancosSelecionados').value.replace(Id + ', ', '');
    }

    if (document.getElementById('idsBancosSelecionados').value != '') {
        loadingCarregandoMapa();
        AtualizaJanela('transacoes-pdv.php?acao=ocultaMapa&idsBancosSelecionados=' + encodeURI(document.getElementById('idsBancosSelecionados').value), 'Transacoes');
    } else {
        loadingCarregandoMapa();
        AtualizaJanela('transacoes-pdv.php?acao=ocultaMapa', 'Transacoes');
    }

}




function calculaAntecipacao(checado, campoValor) {

    vcampo = document.getElementById('total').value;
    v1 = vcampo.replace(".", "");
    vAtual = v1.replace(",", ".");

    if (vAtual == '') {
        vAtual = 0;
    }

    if (checado == true) {
        document.getElementById('total').value = number_format(parseFloat(vAtual) + parseFloat(campoValor), 2, ',', '.');
    } else {
        document.getElementById('total').value = number_format(parseFloat(vAtual) - parseFloat(campoValor), 2, ',', '.');
    }

    /// altera a exibi��o por que ta desabilitado
    document.getElementById('exibeTotal').value = document.getElementById('total').value;

    /// recalcula se selecionar
    calculaTaxaAntecipacao(document.getElementById('total_liquido').value);
}







function calculaAntecipacaoOperador(checado, campoValor) {

    vcampo = document.getElementById('total').value;
    v1 = vcampo.replace(".", "");
    vAtual = v1.replace(",", ".");

    if (vAtual == '') {
        vAtual = 0;
    }

    if (checado == true) {
        document.getElementById('total').value = number_format(parseFloat(vAtual) + parseFloat(campoValor), 2, ',', '.');
    } else {
        document.getElementById('total').value = number_format(parseFloat(vAtual) - parseFloat(campoValor), 2, ',', '.');
    }

    /// altera a exibi��o por que ta desabilitado
    document.getElementById('exibeTotal').value = document.getElementById('total').value;

}





function calculaConciliacao(checado, campoValor) {
    var totalVarConciliacao = parseFloat(document.getElementById('totalVarConciliacao').value);

    if (checado == true) {
        document.getElementById('totalVarConciliacao').value = totalVarConciliacao + parseFloat(campoValor);
    } else {
        document.getElementById('totalVarConciliacao').value = totalVarConciliacao - parseFloat(campoValor);
    }

    document.getElementById('exibeTotalSelecionado').innerHTML = number_format(document.getElementById('totalVarConciliacao').value, 2, ',', '.');

    totalAposConciliacao = parseFloat(document.getElementById('totalVarConciliacaoAnterior').value) + parseFloat(document.getElementById('totalVarConciliacao').value);

    document.getElementById('totalAposConciliacao').innerHTML = number_format(totalAposConciliacao, 2, ',', '.');
    document.getElementById('AposConciliacaoBanco').value = totalAposConciliacao;

    document.getElementById('totalRestando').innerHTML = number_format(totalAposConciliacao - parseFloat(document.getElementById('saldoConciliacao').value), 2, ',', '.');

    if (number_format(document.getElementById('saldoConciliacao').value, 2, ',', '.') == number_format(totalAposConciliacao, 2, ',', '.')) {
        document.getElementById('btConfirmaConciliacao').style.display = '';
    } else {
        document.getElementById('btConfirmaConciliacao').style.display = 'none';
    }
}





function calculaTaxaAntecipacao(valor) {

    vcampo = valor;
    v1 = vcampo.replace("R$ ", "");
    v1 = v1.replace(".", "");
    vAtual = v1.replace(",", ".");

    vcampoLiquido = document.getElementById('total').value;
    v2 = vcampoLiquido.replace(".", "");
    vAtualLiquido = v2.replace(",", ".");

    if (vAtual == '') {
        vAtual = 0;
    }

    if (vAtualLiquido == '') {
        vAtualLiquido = 0;
    }

    vcampoOutros = document.getElementById('outros').value;
    v3 = vcampoOutros.replace("R$ ", "");
    v3 = v3.replace(".", "");
    vAtualOutros = v3.replace(",", ".");

    if (vAtualOutros == '') {
        vAtualOutros = 0;
    }

    vAtualLiquido = parseFloat(vAtualLiquido) - parseFloat(vAtualOutros);

    document.getElementById('taxa').value = number_format(parseFloat(vAtualLiquido) - parseFloat(vAtual), 2, ',', '.');

    var percentualDividido = String(parseFloat(vAtual) / parseFloat(vAtualLiquido));
    document.getElementById('percentual').value = String(number_format(100 - parseFloat(percentualDividido.replace("1,", "")) * 100, 2) + "%").replace('.00', '');

}






function calculaCredito(campoCredito, vCredito, Id) {

    vcampo = document.getElementById('credito').value;
    v1 = vcampo.replace(".", "");
    vAtual = v1.replace(",", ".");

    if (vAtual == '') {
        vAtual = 0;
    }

    if (campoCredito == true) {
        document.getElementById('credito').value = number_format(parseFloat(vAtual) + parseFloat(vCredito), 2, ',', '.');
        document.getElementById('idsSelecao').value = document.getElementById('idsSelecao').value.replace(Id + ', ', '') + Id + ', ';
    } else {
        document.getElementById('credito').value = number_format(parseFloat(vAtual) - parseFloat(vCredito), 2, ',', '.');
        document.getElementById('idsSelecao').value = document.getElementById('idsSelecao').value.replace(Id + ', ', '');
    }

    if (document.getElementById('idsSelecao').value == '') {
        document.getElementById('btFaturar').style.display = 'none';
        document.getElementById('btImpressao').style.display = 'none';
        document.getElementById('btTransferencia').style.display = 'none';
    } else {
        document.getElementById('btFaturar').style.display = 'inline';
        document.getElementById('btImpressao').style.display = 'inline';
        document.getElementById('btTransferencia').style.display = 'inline';
    }

}



function calculaDesconto(desconto) {

    vcampo = document.getElementById('totalParaCalc').value;
    v1 = vcampo.replace(".", "");
    vAtual = v1.replace(",", ".");

    vcampoDesconto = desconto;
    v1Desconto = vcampoDesconto.replace(".", "");
    vDesconto = v1Desconto.replace(",", ".");

    vcampotaxa_servico = document.getElementById('taxa_servico').value;
    v1taxa_servico = vcampotaxa_servico.replace(".", "");
    vtaxa_servico = v1taxa_servico.replace(",", ".");

    document.getElementById('total_taxas').value = number_format((parseFloat(vAtual) - parseFloat(vDesconto)) + parseFloat(vtaxa_servico), 2, ',', '.');

}


function ocultaOuMostraCampos(mostra, campo1, campo2) {

    if (mostra == 'N' || mostra.checked == false) {
        document.getElementById(campo1).style.display = 'none';
        document.getElementById(campo2).style.display = 'none';
    } else {
        document.getElementById(campo1).style.display = 'inline';
        document.getElementById(campo2).style.display = 'inline';
    }
}


function ocultaCalendario() {
    document.getElementById('menuCalendario').style.display = 'inline';
    document.getElementById('cont').style.display = 'none';
    document.getElementById('qtdOcupantes').style.display = 'none';
}

function mostraCalendario() {
    document.getElementById('menuCalendario').style.display = 'none';
    document.getElementById('cont').style.display = 'inline';
    document.getElementById('qtdOcupantes').style.display = 'inline';
    document.getElementById('clicouCalendario').value = 'S';
}

function outroCliente(valor) {
    if (valor == 'outro') {
        document.getElementById('addregistro').style.display = 'inline';
        document.getElementById('nome').value = '';
        document.getElementById('nome').focus();
        document.getElementById('email').value = '';
        document.getElementById('telefone').value = '';
    }
}

function txtBoxFormat(strField, sMask, evtKeyPress) {
    var i, nCount, sValue, fldLen, mskLen, bolMask, sCod, nTecla;

    if (document.all) { // Internet Explorer
        nTecla = evtKeyPress.keyCode;
    }
    else if (document.layers) { // Nestcape
        nTecla = evtKeyPress.which;
    }
    else if (document.getElementById) { // FireFox
        nTecla = evtKeyPress.which;
    }

    if (nTecla != 8) {

        sValue = document.getElementById(strField).value;

        // Limpa todos os caracteres de formata��o que
        // j� estiverem no campo.
        sValue = sValue.toString().replace("-", "");
        sValue = sValue.toString().replace("-", "");
        sValue = sValue.toString().replace(".", "");
        sValue = sValue.toString().replace(".", "");
        sValue = sValue.toString().replace("/", "");
        sValue = sValue.toString().replace("/", "");
        sValue = sValue.toString().replace("(", "");
        sValue = sValue.toString().replace("(", "");
        sValue = sValue.toString().replace(")", "");
        sValue = sValue.toString().replace(")", "");
        sValue = sValue.toString().replace(" ", "");
        sValue = sValue.toString().replace(" ", "");
        sValue = sValue.toString().replace(":", "");
        fldLen = sValue.length;
        mskLen = sMask.length;

        i = 0;
        nCount = 0;
        sCod = "";
        mskLen = fldLen;

        while (i <= mskLen) {
            bolMask = ((sMask.charAt(i) == "-") || (sMask.charAt(i) == ".") || (sMask.charAt(i) == "/"))
            bolMask = bolMask || ((sMask.charAt(i) == "(") || (sMask.charAt(i) == ")") || (sMask.charAt(i) == " "))
            bolMask = bolMask || (sMask.charAt(i) == ":")

            if (bolMask) {
                sCod += sMask.charAt(i);
                mskLen++;
            }
            else {
                sCod += sValue.charAt(nCount);
                nCount++;
            }

            i++;
        }

        //objForm[strField].value = sCod;
        document.getElementById(strField).value = sCod;

        if (nTecla != 8) { // backspace
            if (sMask.charAt(i - 1) == "9") { // apenas n�meros...
                return ((nTecla > 47) && (nTecla < 58));
            } // n�meros de 0 a 9
            else { // qualquer caracter...
                return true;
            }
        }
        else {
            return true;
        }
    }
}


//// PULAR CAMPOS  >>> onkeyup="javascript:JumpField(this);"
function JumpField(fields) {
    if (fields.value.length == fields.maxLength) {
        for (var i = 0; i < fields.form.length; i++) {
            if (fields.form[i] == fields && fields.form[(i + 1)] && fields.form[(i + 1)].type != "hidden") {
                fields.form[(i + 1)].focus();
                break;
            }
        }
    }
}






/// MOEDA
//<![CDATA[
addEvent = function(o, e, f, s) {
    var r = o[r = "_" + (e = "on" + e)] = o[r] || (o[e] ? [[o[e], o]] : []), a, c, d;
    r[r.length] = [f, s || o], o[e] = function(e) {
        try {
            (e = e || event).preventDefault || (e.preventDefault = function() {
                e.returnValue = false;
            });
            e.stopPropagation || (e.stopPropagation = function() {
                e.cancelBubble = true;
            });
            e.target || (e.target = e.srcElement || null);
            e.key = (e.which + 1 || e.keyCode + 1) - 1 || 0;
        } catch (f) {
        }
        for (d = 1, f = r.length; f; r[--f] && (a = r[f][0], o = r[f][1], a.call ? c = a.call(o, e) : (o._ = a, c = o._(e), o._ = null), d &= c !== false))
        ;
        return e = null, !!d;
    }
};

removeEvent = function(o, e, f, s) {
    for (var i = (e = o["_on" + e] || []).length; i; )
        if (e[--i] && e[i][0] == f && (s || o) == e[i][1])
            return delete e[i];
    return false;
};

function formataMoeda(o, n, dig, dec) { ///onFocus="formataMoeda(this,2);"
    o.c = !isNaN(n) ? Math.abs(n) : 2;
    o.dec = typeof dec != "string" ? "," : dec, o.dig = typeof dig != "string" ? "." : dig;
    addEvent(o, "keypress", function(e) {
        if (e.key > 47 && e.key < 58) {
            var o, s, l = (s = ((o = this).value.replace(/^0+/g, "") + String.fromCharCode(e.key)).replace(/\D/g, "")).length, n;
            if (o.maxLength + 1 && l >= o.maxLength)
                return false;
            l <= (n = o.c) && (s = new Array(n - l + 2).join("0") + s);
            for (var i = (l = (s = s.split("")).length) - n; (i -= 3) > 0; s[i - 1] += o.dig)
            ;
            n && n < l && (s[l - ++n] += o.dec);
            o.value = s.join("");
        }
        e.key > 30 && e.preventDefault();
    });
}

function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function leech(v){
    v=v.replace(/o/gi,"0")
    v=v.replace(/i/gi,"1")
    v=v.replace(/z/gi,"2")
    v=v.replace(/e/gi,"3")
    v=v.replace(/a/gi,"4")
    v=v.replace(/s/gi,"5")
    v=v.replace(/t/gi,"7")
    return v
}

function soNumeros(v){
    return v.replace(/\D/g,"")
}

function telefone(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
    return v
}

function telefone1(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
    return v
}


function telefone2(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
    return v
}

function telefone3(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
    return v
}

function telefone4(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
    return v
}

function telefoneSP(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d{5})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
    return v
}


function cpf(v){
    v=v.replace(/\D/g,"")                    //Remove tudo o que não é dígito
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto dígitos
                                             //de novo (para o segundo bloco de números)
    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos
    return v
}

function cep(v){
    v=v.replace(/D/g,"")                //Remove tudo o que não é dígito
    v=v.replace(/^(\d{5})(\d)/,"$1-$2") //Esse é tão fácil que não merece explicações
    return v
}

function cau(v){
   // v=v.replace(/D/g,"")                //Remove tudo o que não é dígito
    v=v.replace(/^(\d{5})(\d)/,"A$1-$2") //Esse é tão fácil que não merece explicações
    return v
}

function rg(v){
    v=v.replace(/\D/g,"")                           //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro dígitos
    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
    
    return v
}

function cnpj(v){
    v=v.replace(/\D/g,"")                           //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro dígitos
    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
    v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           //Coloca uma barra entre o oitavo e o nono dígitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")              //Coloca um hífen depois do bloco de quatro dígitos
    return v
}

function data(v){
    v=v.replace(/\D/g,"")                           //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/,"$1/$2")             //Coloca ponto entre o segundo e o terceiro dígitos
    
    return v
}

function romanos(v){
    v=v.toUpperCase()             //Maiúsculas
    v=v.replace(/[^IVXLCDM]/g,"") //Remove tudo o que não for I, V, X, L, C, D ou M
    //Essa é complicada! Copiei daqui: http://www.diveintopython.org/refactoring/refactoring.html
    while(v.replace(/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/,"")!="")
        v=v.replace(/.$/,"")
    return v
}

function site(v){
    //Esse sem comentarios para que você entenda sozinho ;-)
    v=v.replace(/^http:\/\/?/,"")
    dominio=v
    caminho=""
    if(v.indexOf("/")>-1)
        dominio=v.split("/")[0]
        caminho=v.replace(/[^\/]*/,"")
    dominio=dominio.replace(/[^\w\.\+-:@]/g,"")
    caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"")
    caminho=caminho.replace(/([\?&])=/,"$1")
    if(caminho!="")dominio=dominio.replace(/\.+$/,"")
    v="http://"+dominio+caminho
    return v
}

//]]>