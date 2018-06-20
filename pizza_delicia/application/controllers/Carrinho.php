<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrinho extends CI_Controller {

  /**
   * Página de Cadastro do sistema Pizzaria Delícia.
   *
   */
  public function index($page = 'carrinho') {
    /*@ $nome = ucfirst($_POST["nome"]);
    @ $tel = $_POST["tel"];
    @ $email = $_POST["email"];
    @ $senha = $_POST["senha"];
    @ $qtdEnd = $_POST["qtdEnd"];
    $endereco = array();
    for ($i=1; $i <= $qtdEnd; $i++) {
        @ $rua = ucfirst($_POST["rua".$i]);
        @ $num = ucfirst($_POST["num".$i]);
        @ $bairro = ucfirst($_POST["bairro".$i]);
        @ $cidade = ucfirst($_POST["cidade".$i]);
        $endereco[$i-1] = array('rua' => $rua, 'num' => $num, 'bairro' => $bairro, 'cidade' => $cidade);
    }

    $data['cadastrou'] = $nome != null && $tel != null && $email != null && $senha != null;
    if ($data['cadastrou']) {
      $this->load->model('cliente_model');
      $this->cliente_model->insere_cliente($nome, $tel, $email, $senha, $endereco);//insere cliente e seus endereços respectivos
    }
    */
    $this->load->model('cliente_model');
    $this->load->model('pedido_model');
    $this->load->model('produto_model');

    $data['enderecos'] = $this->cliente_model->get_enderecos(28); //pega enderecos ligados ao cliente passado
    $data['pedidos'] = $this->pedido_model->get_itens_pedidos(28);
    //$data['pedidos'] = array(array('nome' => 'Pizza de Calabresa', 'tamanho' => array('P', 'M', 'G', 'F')), array('nome' => 'Pizza de Fangro', 'tamanho' => array('P', 'M', 'G', 'F')));
    //$data['enderecos'] = array(array('rua' => 'Rua 08 de janeiro', 'numero' => "106", 'bairro' => 'Brasília', 'cidade' => 'Cruz'));

    for($i = 0; $i < count($data['pedidos']); $i++) {//add o indice de nome no pedido para colocar direto na tabela de viewe no carrinho
      $data['pedidos'][$i]['nome'] = $this->produto_model->get_produto($data['pedidos'][$i]['prodID'], 'nome');
    }

    for($i = 0; $i < count($data['pedidos']); $i++) {//add o indice de nome no pedido para colocar direto na tabela de viewe no carrinho
      $cat = $this->produto_model->get_produto($data['pedidos'][$i]['prodID'], 'categoria');
      if($cat == 'P')
        $data['pedidos'][$i]['tamanho'] = array('P', 'M', 'G', 'F');
      else
        $data['pedidos'][$i]['tamanho'] = array('P', 'M');
    }

    $data['title'] = ucfirst($page);
    $this->load->view('templates/header', $data);
    $this->load->view('pages/'.$page, $data);
    $this->load->view('templates/footer');
  }
}