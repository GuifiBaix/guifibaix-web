<?php

$debug = 0;
$from_address = "noreply@guifibaix.coop";
// split address in two to avoid mail being scanned by robots
$to_user  = "equipo";
$to_domain = "guifibaix.coop";
$to_address = "$to_user@$to_domain";
$subject = "[GuifiBaix feedback] from ";

$debug and ini_set('display_errors', 'On');
$debug and error_reporting(E_ALL | E_STRICT);

function badRequest($message = "Error 400: Bad Request")
{
	header("HTTP/1.1 400 Bad Request");
	echo $message;
	exit();
}


if (!$debug && ! isset($_SERVER['HTTP_REFERER'])) badRequest("");
$referrer = $_SERVER['HTTP_REFERER'];

if ($debug)
{
	echo '<pre>';
	var_dump($_POST);
}

class MissingField extends Exception
{
	function __construct($field)
	{
		parent::__construct("Missing field '$field'");
	}
};

/// Safely retrieves post data or throws unless a default value is provided
function post($field, $default=Null)
{
	if (!isset($_POST[$field]))
	{
		if (!is_null($default)) return $default;
		throw new MissingField($field);
	}
	if (empty($_POST[$field]) and !is_null($default))
		return $default;
	return $_POST[$field];
}

date_default_timezone_set("UTC");
$random_hash = md5(rand());

try
{
	$kind = post('kind', 'bad');
	$nom = post('nom');
	$cognoms = post('cognoms');
	$telefon = post('telefon');
	$email = post('email');
	$municipi = post('municipi');
	$adreca = post('adreca');
	$comentari = post('comentari');

	// Optional params
	$yuemail = post('yuemail', 666);
	$filledbyspammers = $yuemail != 666;
}
catch (MissingField $e)
{
	badRequest($e->getMessage());
}

if (! in_array($kind, array(
		"diy",
		"pressupost",
		"dubtes",
		"connectivitat",
	)))
{
	badRequest("Not the proper form");
}

$subject = "[GuifiBaix Web] $kind: $nom $cognoms";

if ($filledbyspammers)
{
	exit();
	$subject = "[GuifiBaix Web] SPAM comment received";
}

$city_names = array(
	'sjd' => 'Sant Joan Despí',
	'prll' => 'El Prat de Llobregat',
	'crnll' => 'Cornellà de Llobregat',
	'edll' => 'Esplugues de Llobregat',
	'scll' => 'Sant Climent de Llobregat',
	'scc' => 'Santa Coloma de Cervelló',
	'vldc' => 'Viladecans',
	'tdll' => 'Torrelles de Llobregat',
	'sbdl' => 'Sant Boi de Llobregat',
	'sfdl' => 'Sant Feliu de Llobregat',
	'svdh' => 'Sant Vicenç dels Horts',
	'sjud' => 'Sant Just Desvern',
	'kstf' => 'Castelldefels',
	'mdr' => 'Molins de Rei',
	'ppl' => 'El Papiol',
	'gava' => 'Gava',
	'sadb' => 'Sant Andreu de la Barca',
	'baix' => 'Un altre municipi del Baix',
	'other' => 'Un altre fora del Baix',
);

$city_cp = array(
	'sjd' => '08970',
	'prll' => '08820',
	'crnll' => '08940',
	'edll' => '08950',
	'scll' => '08849',
	'scc' => '08690',
	'vldc' => '08840',
	'tdll' => '08629',
	'sbdl' => '08830',
	'sfdl' => '08980',
	'svdh' => '08620',
	'sjud' => '08960',
	'kstf' => '08860',
	'mdr' => '08750',
	'ppl' => '08036',
	'gava' => '08850',
	'sadb' => '08740',
);

$cp = $city_cp[$municipi] || '??';
$municipi_name = $city_names[$municipi] || '??';

if ($debug)
{
	echo '</pre>';
}

$yaml_file= <<<EOF
name: $nom
familyname: $cognoms
type: $kind
contact:
  phone:
  - $telefon
  email:
  - $email
address: $adreca
citycode: $municipi
city: $municipi_name
cp: $cp
content: <
$comentari
log:
- $isodate [webform] Contacted through the $kind webform

EOF;

$message = <<<EOF
--Multipart-boundary-$random_hash
Content-Type: text/plain; charset="utf-8

Someone filled the form at:
$referrer

Name: $cognoms, $nom <$email>
Type: $kind
Telf: $telefon
Address:
$adreca
Spammer inserted email (666=notspam): $yuemail
Content:
------------------
$comentari
------------------

--Multipart-boundary-$random_hash
Content-Type: text/yaml; name="$id.yaml"; charset="utf-8"
Content-Disposition: attachment

$yaml_file
EOF;

if (! $debug )
{

	$ok = @mail(
		$to_address,
		$subject,
		$message,
		join("\r\n",array(
			"From: $from_address",
			"Reply-To: $email",
			"Content-Type: multipart/mixed; boundary=\"Multipart-boundary-$random_hash\"" 
			))
		);
	if ($ok)
	{
		echo <<<EOF
<html>
<head> <meta charset="utf-8" /> </head>
<body>
<p>Gràcies, atendrem la vostra soŀlicitud tan aviat com poguem.
</p>
<p><a href='$referrer'>Torna a GuifiBaix.coop</a></p>
</body>
</html>
EOF;

	}
	else
	{
		echo <<<EOF
<html>
<head> <meta charset="utf-8" /> </head>
<body>
<p>We are sorry. There was a problem submiting your comment.
</p><p>
Below you have the content of your comment so that you can copy it and submit it later.</p>
<pre>
Title: $title
------------------
$comment
------------------
</pre>
<p><a href='$referrer'>Back to the post</a></p>
</body>
</html>
EOF;
	}
}
?>