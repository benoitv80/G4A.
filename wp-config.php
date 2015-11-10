<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Le script de création wp-config.php utilise ce fichier lors de l'installation.
 * Vous n'avez pas à utiliser l'interface web, vous pouvez directement
 * renommer ce fichier en "wp-config.php" et remplir les variables à la main.
 * 
 * Ce fichier contient les configurations suivantes :
 * 
 * * réglages MySQL ;
 * * clefs secrètes ;
 * * préfixe de tables de la base de données ;
 * * ABSPATH.
 * 
 * @link https://codex.wordpress.org/Editing_wp-config.php 
 * 
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'bddgfa');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', '');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'gjDh@%iW}uic6?:>xInNho3s:Zb/peyg59a?=<GNH[wLZS6$9]3|~Hn?LgQE7i=,');
define('SECURE_AUTH_KEY',  'i0Ne:u+pCfuzU=C+VfCOo_z[>ln;%W[e>g-h$[Z@`/nS*e9eW]C]FsCmQLtP(,H+');
define('LOGGED_IN_KEY',    'L?Jtmai3|)Hp^dJ=H|dnl{9Sz0,ma-r|^Nk{OR$R9xQ nYaG)WL5]UJSZ[494-`w');
define('NONCE_KEY',        '=2zQM^lY4G/klgq[#IqU0EmU2)Y }HgCDg=0k7Iz|2m.i2nhg_9-%x.w7>byKON=');
define('AUTH_SALT',        'v):Y~Pg[`|3N-mMpHcwsh;ReubCp+!_51J;w!7~v1H.;]@F}(h2Z29f.9Mn;SCJ?');
define('SECURE_AUTH_SALT', '03`wv37Tg7iPslFuzL|V:FBTSFC@,Y@zt0?%VZ0-/*4c}Es_yHt#vp?i7Tg{Z2xo');
define('LOGGED_IN_SALT',   'J5p:|eYBM04|9cZP6kl^U0icxAeWKXz/9xqIIl{(Z,DRp}3Q/Y.(sP2IcB~H6EdG');
define('NONCE_SALT',       '7U7j`lt;%IUbun:G*-@.p?^^ P?ZhuY;E3.TvV9OjvC 7r>I?<2x4$D7Y?yE16Wx');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_';

/** 
 * Pour les développeurs : le mode déboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 * 
 * Pour obtenir plus d'information sur les constantes 
 * qui peuvent être utilisée pour le déboguage, consultez le Codex.
 * 
 * @link https://codex.wordpress.org/Debugging_in_WordPress 
 */ 
define('WP_DEBUG', false); 

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');