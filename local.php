<?php

    $url = 'http://37.187.119.228/temps-reel/';

    $t0 = microtime(true);
    // sleep(2);

    $localeDate = date('m/d/Y H:i:s');

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL,$url);
    $result=curl_exec($curl);
    curl_close($curl);

    // sleep(3);
    $t3 = microtime(true);

    $result = json_decode($result);

    $decalageTS = strtotime($result->date) - strtotime($localeDate);
    $t2 = $result->T2 - $decalageTS; // On se cale sur l'heure locale sinon les données sont faussées
    $t1 = $result->T1 - $decalageTS; // On se cale sur l'heure locale sinon les données sont faussées

    $decalage = date('i \m\i\n s \s', $decalageTS);
    $theta = (($t1 - $t0) + ($t2 - $t3)) / 2;

    echo "
    <h1>Comparateur d'heures serveur/client</h1>
      <table border='1'>
        <tr>
          <th>Heure serveur</th><th>Heure client</th><th>Décalage</th>
        </tr>
        <tr>
          <td>{$result->date}</td><td>{$localeDate}</td><td>{$decalage}</td>
        </tr>
      </table>
    ";

    echo "
    <h1>Calcul du décalage d'horloge</h1>
      <table border='1'>
        <tr>
          <th>T0 (client)</th><th>T1 (serveur)</th><th>T2 (serveur)</th><th>T3 (client)</th><th>ϴ</th>
        </tr>
        <tr>
          <td>{$t0}</td><td>{$t1}</td><td>{$t2}</td><td>{$t3}</td><td>{$theta}</td>
        </tr>
      </table>
    ";