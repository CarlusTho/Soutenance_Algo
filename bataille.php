<?php

echo ("Bienvenu(e) à la bataille! \n");

function array_cartesian_product () {
    if (!$c = func_num_args())
        return array();
 
    if ($c == 1) {
        foreach ((array)func_get_arg(0) as $v)
            $r[] = (array)$v;
        return $r;
    }
 
    $a = func_get_args();
    $f = array_shift($a);
    $s = call_user_func_array(__FUNCTION__, $a);
 
    foreach ((array)$f as $v) {
        foreach ($s as $w) {
            array_unshift($w, $v);
            $r[] = $w;
        }
    }
 
    return $r;
}
 
$colors = array('Pique', 'Coeur', 'Carreau', 'Trèfle');
$values = array_merge(range(2,10), array('Valet', 'Dame', 'Roi', 'As'));
 
// créer le jeu de cartes

$deck = array_map('implode', array_cartesian_product($values, ' de ', $colors));

// mélanger en gardant les clefs

function shuffle_assoc($deck) {
  if (!is_array($deck)) return $deck;

  $keys = array_keys($deck);
  shuffle($keys);
  $random = array();
  foreach ($keys as $key)
    $random[$key] = $deck[$key];

  return $random;
} 

shuffle_assoc($deck);
$deckJ1 = array_slice($deck, 0, 26, true);
$deckJ2 = array_slice($deck, 26, 26, true);

var_dump($deckJ1);
var_dump($deckJ2);

// conditions de victoire

function bataille ($deckJ1, $deckJ2)
{

    while (isset($deckJ1[0], $deckJ2[0]))
    {
        // tirer deux cartes
        readline("Taper sur une touche pour tirer pour tirer les cartes");

        $vieJ1 = count($deckJ1) - 1;
        $i = array_keys($deckJ1, $vieJ1);

        $vieJ2 = count($deckJ2) - 1;
        $j = array_keys($deckJ2, $vieJ2);

        $card1 = array_pop($deckJ1);
        $card2 = array_pop($deckJ2);

        echo ("J'ai un(e) : \t" . $card2 . "\n");
        echo ("Vous avez un(e) :\t" . $card1 . "\n");

        // déterminer le gagnant

        if ($i[0] > $j[0])
        {
            readline("Vous remportez la manche");
            array_reverse($deckJ1);         // mieux que array_unshift()
            array_push($deckJ1, $card2);
            array_reverse($deckJ1);

        }elseif ($i[0] < $j[0])
        {
            readline("Vous perdez la manche");
            array_reverse($deckJ2);         // mieux que array_unshift()
            array_push($deckJ2, $card1);
            array_reverse($deckJ2);
            
        }else 
        {
            readline("Il y a égalité");
            bataille($deckJ1, $deckJ2);
        }
    }

    if (isset($deckJ1[0])){
        echo("Bravo, vous avez gagné!");
    }else
    {
        echo("J'ai gagné et vous avez perdu");
    }
}

bataille($deckJ1, $deckJ2);

?>