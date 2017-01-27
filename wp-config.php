<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa user o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações
// com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'db_wp_teste1');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '04Delys13');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'm?&FIbcD z/~>,ho=7,B+j^6QIs=pa B9cyh5ly|~4DJpM&o,=spEe7-}@y@l{Tl');
define('SECURE_AUTH_KEY',  'S@rKG nEcyKA^>t5{Kf8w9l0E1WVs#t0nr*Qtck:0P>z7UF-S*-yI0xA$G dcykY');
define('LOGGED_IN_KEY',    '1|8QYfBI:#S9c(,{xH~B/200k4rUx}!#Mirsf~4e9Pd0t RwUE{ekkX;SdbC5}59');
define('NONCE_KEY',        '<ZxwUS!h/pAaCeT+<Qw{o5U^Rw`O2hVH%)>/n<AI5SC2*8H.nWr`P>&,vP}/F(E@');
define('AUTH_SALT',        'E_24:#ODdmB3EQZ>igOet9fP<Jjm~y.cHB)fFKip8s>eoYIT_BJ3w;>VQ#CPzv#r');
define('SECURE_AUTH_SALT', '/L`+G4cBmfNx_5@T+v<U5,8_T2xS`$U2xA3ALkPRa_c@+Z/ECl,dY:Kin1Gj$]jr');
define('LOGGED_IN_SALT',   'NmJxNrkx8|*!lzXBSmojQ4DPL#[hVy 3~{% zDxZY(03S_TQ_bRgr9)KwE)WVxLe');
define('NONCE_SALT',       'Ci 4O6h5^anpeCCC++]v}t!qb%L[#O;]2:=U,R}E?Z)L2Ww{HxR$FqfyDvXzlV m');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * para cada um um único prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
define('FS_METHOD','direct');
