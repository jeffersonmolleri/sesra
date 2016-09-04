<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Dicion&aacute;rio de dados</title> 
<style type="text/css"> 
@charset "UTF-8";
/**
 * "Yet Another Multicolumn Layout" - (X)HTML/CSS Framework
 *
 * (en) Uniform design of standard content elements
 * (de) Einheitliche Standardformatierungen für die wichtigten Inhalts-Elemente
 *
 * @copyright       Copyright 2005-2009, Dirk Jesse
 * @license         CC-A 2.0 (http: //creativecommons.org/licenses/by/2.0/),
 *                  YAML-C (http: //www.yaml.de/en/license/license-conditions.html)
 * @link            http: //www.yaml.de
 * @package         yaml
 * @version         3.2
 * @revision        $Revision: 392 $
 * @lastmodified    $Date: 2009-07-05 12: 18: 40 +0200 (So, 05. Jul 2009) $
 * @appdef yaml
 */

@media all
{
 /**
  * Fonts
  *
  * (en) global settings of font-families and font-sizes
  * (de) Globale Einstellungen für Zeichensatz und Schriftgrößen
  *
  * @section content-global-settings
  */

  /* (en) reset font size for all elements to standard (16 Pixel) */
  /* (de) Alle Schriftgrößen auf Standardgröße (16 Pixel) zurücksetzen */
  html * { font-size: 100.01%; }

 /**
  * (en) reset monospaced elements to font size 16px in all browsers
  * (de) Schriftgröße von monospaced Elemente in allen Browsern auf 16 Pixel setzen
  *
  * @see:  http: //webkit.org/blog/67/strange-medium/
  */

  textarea, pre, code, kbd, samp, var, tt {
    font-family: Consolas, "Lucida Console", "Andale Mono", "Bitstream Vera Sans Mono", "Courier New", Courier;
  }

  /* (en) base layout gets standard font size 12px */
  /* (de) Basis-Layout erhält Standardschriftgröße von 12 Pixeln */
  body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 75.00%;
    color: #444;
  }

  /*--- Headings | Überschriften ------------------------------------------------------------------------*/

  h1,h2,h3,h4,h5,h6 {
    font-family: Arial, Helvetica, sans-serif;
    font-weight: normal;
    color: #222;
    margin: 0 0 0.25em 0;
  }

  h1 { font-size: 250%; }                       /* 30px */
  h2 { font-size: 200%; }                       /* 24px */
  h3 { font-size: 150%; }                       /* 18px */
  h4 { font-size: 133.33%; }                    /* 16px */
  h5 { font-size: 116.67%; }                    /* 14px */
  h6 { font-size: 116.67%; }                    /* 14px */

  /* --- Lists | Listen  -------------------------------------------------------------------------------- */

  ul, ol, dl { line-height: 1.5em; margin: 0 0 1em 1em; }
  ul { list-style-type: disc; }
  ul ul { list-style-type: circle; margin-bottom: 0; }

  ol { list-style-type: decimal; }
  ol ol { list-style-type: lower-latin; margin-bottom: 0; }

  li { margin-left: 0.8em; line-height: 1.5em; }

  dt { font-weight: bold; }
  dd { margin: 0 0 1em 0.8em; }

  /* --- general text formatting | Allgemeine Textauszeichnung ------------------------------------------ */

  p { line-height: 1.5em; margin: 0 0 1em 0; }

  blockquote, cite, q {
    font-family: Georgia, "Times New Roman", Times, serif;
    font-style: italic;
  }
  blockquote { margin: 0 0 1em 1.6em; color: #666; }

  strong,b { font-weight: bold; }
  em,i { font-style: italic; }

  big { font-size: 116.667%; }
  small { font-size: 91.667%; }
 
  pre { line-height: 1.5em; margin: 0 0 1em 0; }
  pre, code, kbd, tt, samp, var { font-size: 100%; }
  pre, code { color: #800; }
  kbd, samp, var, tt { color: #666; font-weight: bold; }
  var, dfn { font-style: italic; }

  acronym, abbr {
    border-bottom: 1px #aaa dotted;
    font-variant: small-caps;
    letter-spacing: .07em;
    cursor: help;
  }

  sub, sup { font-size: 91.6667%; line-height: 0; }
	
	.fontinc { font-size: 109.0908%; }
	.fontred { font-size: 91.6667%; }

  hr {
    color: #ccc;
    background: transparent;
    margin: 0 0 0.5em 0;
    padding: 0;
    border: 0;
    border-bottom: 1px #ccc solid;
		height: 1px;
  }

  /*--- Links ----------------------------------------------------------------------------------------- */

  a { color: #4D87C7; background: transparent; text-decoration: none; }
  a: visited  { color: #036; }

  a: focus,
  a: hover,
  a: active { color: #182E7A; text-decoration: underline; }

  /* --- images (with optional captions) | Bilder (mit optionaler Bildunterschrift) ------------------ */

  p.icaption_left { float: left; display: inline; margin: 0 1em 0.15em 0; }
  p.icaption_right { float: right; display: inline; margin: 0 0 0.15em 1em; }

  p.icaption_left img,
  p.icaption_right img { padding: 0; border: 1px #888 solid; }

  p.icaption_left strong,
  p.icaption_right strong { display: block; overflow: hidden; margin-top: 2px; padding: 0.3em 0.5em; background: #eee; font-weight: normal; font-size: 91.667%; }

 /**
  * ------------------------------------------------------------------------------------------------- #
  *
  * Generic Content Classes
  *
  * (en) standard classes for positioning and highlighting
  * (de) Standardklassen zur Positionierung und Hervorhebung
  *
  * @section content-generic-classes
  */

  .highlight { color: #c30; }
  .dimmed { color: #888; }

  .info { background: #f8f8f8; color: #666; padding: 10px; margin-bottom: 0.5em; font-size: 91.7%; }

  .note { background: #efe; color: #040; border: 2px #484 solid; padding: 10px; margin-bottom: 1em; }
  .important { background: #ffe; color: #440; border: 2px #884 solid; padding: 10px; margin-bottom: 1em; }
  .warning { background: #fee; color: #400; border: 2px #844 solid; padding: 10px; margin-bottom: 1em; }

  .float_left { float: left; display: inline; margin-right: 1em; margin-bottom: 0.15em; }
  .float_right { float: right; display: inline; margin-left: 1em; margin-bottom: 0.15em; }
  .center { display: block; text-align: center; margin: 0.5em auto; }

 /**
  * ------------------------------------------------------------------------------------------------- #
  *
  * Tables | Tabellen
  *
  * (en) Generic classes for table-width and design definition
  * (de) Generische Klassen für die Tabellenbreite und Gestaltungsvorschriften für Tabellen
  *
  * @section content-tables
  */

  table { width: 100%; border-collapse: collapse; margin-bottom: 0.5em; border-top: 2px #888 solid; border-bottom: 2px #888 solid; }
  table caption { font-variant: small-caps; }
  table.full { width: 100%; }
  table.fixed { table-layout: fixed; }

  th,td { padding: 0.5em; }
  thead th { background: #e8e8ee; color: #000; border-bottom: 1px #888 solid; }
  tbody th { background: #f8f8ff; color: #333; }
  tbody th[scope="row"], tbody th.sub { background: #f8f8ff; }

  tbody th { border-bottom: 1px solid #fff; text-align: left; }
  tbody td { border-bottom: 1px solid #eee; }

  tbody tr:hover th[scope="row"],
  tbody tr:hover tbody th.sub { background: #cccc99; }
  tbody tr:hover td { background: #eeeeff; }

 /**
  * ------------------------------------------------------------------------------------------------- #
  *
  * Miscellaneous | Sonstiges
  *
  * @section content-misc
  */

 /**
  * (en) Emphasizing external Hyperlinks via CSS
  * (de) Hervorhebung externer Hyperlinks mit CSS
  *
  * @section             content-external-links
  * @app-yaml-default    disabled
  */

  /*
  #main a[href^="http: //www.my-domain.com"],
  #main a[href^="https: //www.my-domain.com"]
  {
    padding-left: 12px;
    background-image: url('your_image.gif');
    background-repeat: no-repeat;
    background-position: 0 0.45em;
  }
  */
}

</style>
</head> 
<body>
<?php
error_reporting(E_ALL);
$db = new PDO('pgsql:host=server;dbname=mestrado', 'postgres', 'enova');

$rs = $db->query('SELECT pc.relname AS tablename, pa.attname AS column, pg_catalog.format_type(pa.atttypid, pa.atttypmod) AS datatype, pd.description
FROM pg_class pc 
INNER JOIN pg_attribute pa ON pa.attrelid = pc.oid AND pa.attnum > 0
LEFT JOIN pg_description pd ON pd.objoid = pc.oid AND pd.objsubid = pa.attnum
WHERE pc.relowner = 10 AND pc.relnamespace = 2200 AND pc.relkind = \'r\'');

$data = array();

foreach ($rs as $r) {
  if (!array_key_exists($r[0], $data)) {
    $data[$r[0]] = array();
  }
  $data[$r[0]][] = array($r[1], $r[2], $r[3]);
}

foreach ($data as $t => $d) : ?>
<h1><?php echo $t ?></h1>
<table>
  <thead>
    <tr>
      <th>Campo</th>
      <th>Tipo</th>
      <th>Descri&ccedil;&atilde;o</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($d as $r) : ?>
    <tr>
      <td><?php echo $r[0] ?></td>
      <td><?php echo $r[1] ?></td>
      <td><?php echo $r[2] ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php endforeach; 

$db = null;
?>
</body>
</html>
