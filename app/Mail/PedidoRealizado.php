<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;

class PedidoRealizado extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $dados;

    public function __construct(array $dados)
    {
        $this->dados = $dados;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
            $data = array('name'=>"Challenge Doc88");


            $string_texto = "Olá ".$this->dados["cliente"]["nome"].",\n";
            $string_texto.="Recebemos seu novo pedido de número: ".$this->dados["id"]."\n\n";
            $string_texto.="Dados do cliente:\n";
            $string_texto.="Nome: ".$this->dados["cliente"]["nome"]."\n";
            $string_texto.="Email: ".$this->dados["cliente"]["email"]."\n";
            $string_texto.="Telefone: ".$this->dados["cliente"]["telefone"]."\n";
            $string_texto.="Data de Nascimento: ".$this->dados["cliente"]["data_de_nascimento"]."\n";
            $string_texto.="Endereço: ".$this->dados["cliente"]["endereco"]."\n";
            $string_texto.="Complemento: ".$this->dados["cliente"]["complemento"]."\n";
            $string_texto.="Bairro: ".$this->dados["cliente"]["bairro"]."\n";
            $string_texto.="CEP: ".$this->dados["cliente"]["cep"]."\n\n\n";
            $string_texto.="No pedido, há os seguintes itens:\n";
            foreach ($this->dados["itens"] as $produtos) {
                $string_texto.= "- I.D: ".$produtos["pastel"]["id"]." Quantidade: ".$produtos["quantidade"]." - ".$produtos["pastel"]["nome"].", R$".$produtos["pastel"]["preco"]."/cada\n";
            }
            $string_texto.= "\n\n\n\n";
            $string_texto.= "Agradecemos a sua preferência.";
            Mail::send(['text'=>$string_texto], $data, function($message) {
               $message->to($this->dados["cliente"]["email"], $this->dados["cliente"]["nome"])->subject
                  ('Novo pedido realizado');
               $message->from('doc88@gmail.com','Doc88');
            });
    }
}
