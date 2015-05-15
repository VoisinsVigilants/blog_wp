<?php
/**
 * User: jbrinley
 * Date: 5/22/11
 * Time: 4:14 PM
 */
 
class WP_Router_Sample {
	public static function init() {
		add_action('wp_router_generate_routes', array(get_class(), 'generate_routes'), 10, 1);
	}

	public static function generate_routes( WP_Router $router ) {
		$router->add_route('wp-router-sample', array(
			'path' => 'ambassadeurs',
			'query_vars' => array(
				'sample_argument' => 1,
			),
			'page_callback' => array(get_class(), 'sample_callback'),
			'access_callback' => TRUE,
		));
	}

	public static function sample_callback() {
        $tmp = "<style>
                    #primary {
                        width: 100%;
                    }
                </style>";
        $tmp .= "<div class='titre-ambassadeurs'>Découvrez le blog de votre region</div>
                <div class='sous-titre-ambassadeurs'>Partagez vos expériences avec vos ambassadeurs</div>
        ";
        $alsace = plugins_url( 'img/alsace.png' , __FILE__ );
        $lienAlsace = "/regions-alsace/";

        $aquitaine = plugins_url( 'img/aquitaine.png' , __FILE__ );
        $lienAquitaine = "/regions-aquitaine/";

        $auvergne = plugins_url( 'img/auvergne.png' , __FILE__ );
        $lienAuvergne = "/regions-auvergne/";

        $basse_normandie = plugins_url( 'img/basseNormandie.png' , __FILE__ );
        $lienBasseNormandie = "/regions-basse-normandie/";

        $bourgogne = plugins_url( 'img/bourgogne.png' , __FILE__ );
        $lienBourgogne = "/regions-bourgogne/";

        $bretagne = plugins_url( 'img/bretagne.png' , __FILE__ );
        $lienBretagne = "/regions-bretagne/";

        $centre = plugins_url( 'img/centre.png' , __FILE__ );
        $liencentre = "/regions-centre/";

        $champagneArdenne = plugins_url( 'img/champagneArdenne.png' , __FILE__ );
        $lienChampagneArdenne = "/regions-champagne-ardenne/";

        $corse = plugins_url( 'img/corse.png' , __FILE__ );
        $lienCorse = "/regions-corse/";

        $francheComte = plugins_url( 'img/francheComte.png' , __FILE__ );
        $lienFrancheComte = "/regions-franche-comte/";

        $hauteNormandie = plugins_url( 'img/hauteNormandie.png' , __FILE__ );
        $lienHauteNormandie = "/regions-haute-normandie/";

        $ileDeFrance = plugins_url( 'img/ileDeFrance.png' , __FILE__ );
        $lienIleDeFrance = "/regions-iledefrance/";

        $languedocRoussillon = plugins_url( 'img/languedocRoussillon.png' , __FILE__ );
        $lienLanguedocRoussillon = "/regions-languedoc-roussillon/";

        $limousin = plugins_url( 'img/limousin.png' , __FILE__ );
        $lienLimousin = "/regions-limousin/";

        $lorraine = plugins_url( 'img/lorraine.png' , __FILE__ );
        $lienLorraine = "/regions-lorraine/";

        $midiPyrenees = plugins_url( 'img/midiPyrenees.png' , __FILE__ );
        $lienMidiPyrenees = "/regions-midi-pyrenees/";

        $nordPasDeCalais = plugins_url( 'img/nordPasDeCalais.png' , __FILE__ );
        $lienNordPasDeCalais = "/regions-nord-pas-de-calais/";

        $paca = plugins_url( 'img/paca.png' , __FILE__ );
        $lienPaca = "/regions-paca/";

        $paysDeLaLoire = plugins_url( 'img/paysDeLaLoire.png' , __FILE__ );
        $lienPaysDeLaLoire = "/regions-pays-de-la-loire/";

        $picardie = plugins_url( 'img/picardie.png' , __FILE__ );
        $lienPicardie = "/regions-picardie/";

        $poitouCharente = plugins_url( 'img/poitouCharente.png' , __FILE__ );
        $lienPoitouCharente = "/regions-poitou-charente/";

        $rhoneAlpes = plugins_url( 'img/rhoneAlpes.png' , __FILE__ );
        $lienRhoneAlpes = "/regions-rhone-alpes/";

//         $tmp .= "<div class='list-img'>
//                 <div class='small-img'><img src='$alsace'></div><div class='small-img'><img src='$aquitaine'></div><div class='big-img'><a href='$lienIleDeFrance'><img src='$ileDeFrance'></a></div>
//                 <div class='small-img'><img src='$basse_normandie'></div><div class='big-img'><img src='$bourgogne'></div><div class='small-img'><img src='$bretagne'></div>
//                 <div class='big-img'><img src=$centre></div><div class='small-img'><img src='$champagneArdenne'></div><div class='small-img'><img src='$corse'></div>
//                 <div class='small-img'><img src='$francheComte'></div><div class='small-img'><img src='$hauteNormandie'></div><div class='big-img'><img src='$auvergne'></div>
//                 <div class='small-img'><img src='$languedocRoussillon'></div><div class='big-img'><img src='$limousin'></div><div class='small-img'><a href='$lienLorraine'><img src='$lorraine'><a></div>
//                 <div class='big-img'><img src='$midiPyrenees'></div><div class='small-img'><a href='$lienNordPasDeCalais'><img src='$nordPasDeCalais'></a></div><div class='small-img'><img src='$paca'></div>
//                 <div class='small-img'><img src='$paysDeLaLoire'></div><div class='small-img'><img src='$picardie'></div><div class='big-img'><img src='$poitouCharente'></div>
//                 <div class='big-img'><img src='$rhoneAlpes'></div>
//                 </div>";
        
        $tmp .= "<div class='list-img'>
        <div class='small-img'><a href='$lienAlsace'><img src='$alsace'></a></div><div class='small-img'><a href='$lienNordPasDeCalais'><img src='$nordPasDeCalais'></a></div><div class='big-img'><a href='$lienIleDeFrance'><img src='$ileDeFrance'></a></div>
        <div class='small-img'><a href='$lienLorraine'><img src='$lorraine'></a></div><div class='big-img'><a href='$lienChampagneArdenne'><img src='$champagneArdenne'></a></div><div class='small-img'><a href='$lienAquitaine'><img src='$aquitaine'></a></div>
        <div class='big-img'><a href='$lienPaysDeLaLoire'><img src='$paysDeLaLoire'></a></div><div class='small-img'><a href='$lienLanguedocRoussillon'><img src='$languedocRoussillon'></a></div>
        <div class='small-img'><img src='$francheComte'></div><div class='small-img'><img src='$hauteNormandie'></div><div class='big-img'><img src='$auvergne'></div><div class='small-img'><img src='$bretagne'></div><div class='small-img'><img src='$bourgogne'></div>
        <div class='small-img'><img src='$corse'></div><div class='big-img'><img src='$limousin'></div><div class='small-img'><img src='$basse_normandie'></div>
        <div class='small-img'><img src=$centre></div><div class='big-img'><img src='$midiPyrenees'></div><div class='small-img'><img src='$paca'></div>
        <div class='small-img'><img src='$picardie'></div><div class='big-img'><img src='$poitouCharente'></div>
        <div class='big-img'><img src='$rhoneAlpes'></div>
        </div>";

        
//         <div class='big-img'><img src='$bourgogne'></div>


        echo $tmp;
	}
}
