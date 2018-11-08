# Mailchimp
Integração com a plataforma Mailchimp

@copyright (c) 2018, Davson Santos - (contato@davsonsantos.com.br)

# Como Utilizar?

- Criando o Objeto
```html
required 'Mailchimp.php';
$Mail = new Mailchimp(API_KEY, LIST_ID, SERVER);
```
- Dados Necessários para integração
```html
$Data = [
  'email' => "email@dominio.com", //Obrigatório
]

/********DADOS OPCIONAIS**************/
$Data['name'];
$Data['lastname'];
$Data['birthday'];
$Data['phone'];

# Para cadastrar endereço deve ser informado todos os campos abaixo:
$Data['addr1'];
$Data['addr2'];
$Data['addr1'];
$Data['city'];
$Data['state'];
$Data['zip'];
$Data['coubtry'];
```

```html
Validando a integração
$Result = $mail->setLeadList($Data);
 ```
```html
if (is_numeric($Result->status)):
    echo "<h2>Ocurreu um erro no processo</h2>";
    echo "<p>Tipo: {$Result->type}</p>";
    echo "<p>Titulo: {$Result->title}</p>";
    echo "<p>Status: {$Result->status}</p>";
    echo "<p>Detalhes: {$Result->detail}</p>";
    echo "<p>Instância: {$Result->instance}</p>";
else:
    var_dump($Result);
endif;
```
