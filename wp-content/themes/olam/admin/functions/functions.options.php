<?php
add_action('init','of_options');
if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
			$of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
			$categories_tmp 	= array_unshift($of_categories, esc_html__("Select a category:","olam"));    
		//Access the WordPress Pages via an Array
			$of_pages 			= array();
			$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
			foreach ($of_pages_obj as $of_page) {
				$of_pages[$of_page->ID] = $of_page->post_name; }
				$of_pages_tmp 		= array_unshift($of_pages, esc_html__("Select a page:","olam") );       
		//Testing 
				$of_options_select 	= array("one","two","three","four","five"); 
				$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		//Sample Homepage blocks for the layout manager (sorter)
				$of_options_homepage_blocks = array
				( 
					"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
				), 
					"enabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
				),
					);
		//Stylesheets Reader
				$alt_stylesheet_path = LAYOUT_PATH;
				$alt_stylesheets = array();
				if ( is_dir($alt_stylesheet_path) ) 
				{
					if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
					{ 
						while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
						{
							if(stristr($alt_stylesheet_file, ".css") !== false)
							{
								$alt_stylesheets[] = $alt_stylesheet_file;
							}
						}    
					}
				}
		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
			if ($bg_images_dir = opendir($bg_images_path) ) { 
				while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
					if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		            	natsort($bg_images); //Sorts the array into a natural order
		            	$bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		
		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		$fontsize=array(
			'8' => 8,
			'9' => 9,
			'10' => 10,
			'11' => 11,
			'12' => 12,
			'14' => 14,
			'16' => 16,
			'18' => 18,
			'20' => 20,
			'22' => 22,
			'24' => 24,
			'26' => 26,
			'28' => 28,
			'30' => 30,
			'32' => 32,
			'34' => 34,
			'36' => 36,
			'38' => 38,
			'40' => 40,
			'42' => 42,
			'44' => 44,
			'46' => 46,
			'48' => 48,
			'50' => 50,
			'52' => 52,
			'54' => 54,
			'56' => 56,
			'58' => 58,
			'60' => 60,
			'62' => 62,
			'64' => 64,
			'66' => 66,
			'68' => 68,
			'70' => 70,
			'72' => 72
			);
		$fontsizemenu=array(
			'8' => 8,
			'9' => 9,
			'10' => 10,
			'11' => 11,
			'12' => 12,
			'14' => 14,
			'16' => 16,
			'18' => 18,
			'20' => 20,
			'22' => 22,
			'24' => 24,
			'26' => 26,
			'30' => 30,
			'36' => 36,
			'48' => 48,
			'60' => 60,
			'72' => 72
			);
		$fontsizeheader=array(
			'8' => 8,
			'9' => 9,
			'10' => 10,
			'11' => 11,
			'12' => 12,
			'14' => 14,
			'16' => 16,
			'18' => 18,
			'20' => 20,
			'22' => 22,
			'24' => 24,
			'26' => 26,
			'30' => 30,
			'36' => 36,
			'48' => 48,
			'60' => 60,
			'72' => 72
			);
		$fonts = array(
			"none" => "Select a font",
			'arial'=>'Arial',
			'verdana'=>'Verdana, Geneva',
			'trebuchet'=>'Trebuchet',
			'trebuchet ms'=>'Trebuchet MS',
			'georgia' =>'Georgia',
			'times'=>'Times New Roman',
			'tahoma'=>'Tahoma, Geneva',
			'helvetica'=>'Helvetica',
			'Abel' => 'Abel',
			'Abril Fatface' => 'Abril Fatface',
			'Aclonica' => 'Aclonica',
			'Acme' => 'Acme',
			'Actor' => 'Actor',
			'Adamina' => 'Adamina',
			'Advent Pro' => 'Advent Pro',
			'Aguafina Script' => 'Aguafina Script',
			'Aladin' => 'Aladin',
			'Aldrich' => 'Aldrich',
			'Alegreya' => 'Alegreya',
			'Alegreya SC' => 'Alegreya SC',
			'Alex Brush' => 'Alex Brush',
			'Alfa Slab One' => 'Alfa Slab One',
			'Alice' => 'Alice',
			'Alike' => 'Alike',
			'Alike Angular' => 'Alike Angular',
			'Allan' => 'Allan',
			'Allerta' => 'Allerta',
			'Allerta Stencil' => 'Allerta Stencil',
			'Allura' => 'Allura',
			'Almendra' => 'Almendra',
			'Almendra SC' => 'Almendra SC',
			'Amaranth' => 'Amaranth',
			'Amatic SC' => 'Amatic SC',
			'Amethysta' => 'Amethysta',
			'Andada' => 'Andada',
			'Andika' => 'Andika',
			'Angkor' => 'Angkor',
			'Annie Use Your Telescope' => 'Annie Use Your Telescope',
			'Anonymous Pro' => 'Anonymous Pro',
			'Antic' => 'Antic',
			'Antic Didone' => 'Antic Didone',
			'Antic Slab' => 'Antic Slab',
			'Anton' => 'Anton',
			'Arapey' => 'Arapey',
			'Arbutus' => 'Arbutus',
			'Architects Daughter' => 'Architects Daughter',
			'Arimo' => 'Arimo',
			'Arizonia' => 'Arizonia',
			'Armata' => 'Armata',
			'Artifika' => 'Artifika',
			'Arvo' => 'Arvo',
			'Asap' => 'Asap',
			'Asset' => 'Asset',
			'Astloch' => 'Astloch',
			'Asul' => 'Asul',
			'Atomic Age' => 'Atomic Age',
			'Aubrey' => 'Aubrey',
			'Audiowide' => 'Audiowide',
			'Average' => 'Average',
			'Averia Gruesa Libre' => 'Averia Gruesa Libre',
			'Averia Libre' => 'Averia Libre',
			'Averia Sans Libre' => 'Averia Sans Libre',
			'Averia Serif Libre' => 'Averia Serif Libre',
			'Bad Script' => 'Bad Script',
			'Balthazar' => 'Balthazar',
			'Bangers' => 'Bangers',
			'Basic' => 'Basic',
			'Battambang' => 'Battambang',
			'Baumans' => 'Baumans',
			'Bayon' => 'Bayon',
			'Belgrano' => 'Belgrano',
			'Belleza' => 'Belleza',
			'Bentham' => 'Bentham',
			'Berkshire Swash' => 'Berkshire Swash',
			'Bevan' => 'Bevan',
			'Bigshot One' => 'Bigshot One',
			'Bilbo' => 'Bilbo',
			'BioRhyme' => 'BioRhyme',
			'Bitter' => 'Bitter',
			'Black Ops One' => 'Black Ops One',
			'Bokor' => 'Bokor',
			'Bonbon' => 'Bonbon',
			'Boogaloo' => 'Boogaloo',
			'Bowlby One' => 'Bowlby One',
			'Bowlby One SC' => 'Bowlby One SC',
			'Brawler' => 'Brawler',
			'Bree Serif' => 'Bree Serif',
			'Bubblegum Sans' => 'Bubblegum Sans',
			'Buda' => 'Buda',
			'Buenard' => 'Buenard',
			'Butcherman' => 'Butcherman',
			'Butterfly Kids' => 'Butterfly Kids',
			'Cabin' => 'Cabin',
			'Cabin Condensed' => 'Cabin Condensed',
			'Cabin Sketch' => 'Cabin Sketch',
			'Caesar Dressing' => 'Caesar Dressing',
			'Cagliostro' => 'Cagliostro',
			'Calligraffitti' => 'Calligraffitti',
			'Cambo' => 'Cambo',
			'Candal' => 'Candal',
			'Cantarell' => 'Cantarell',
			'Cantata One' => 'Cantata One',
			'Cardo' => 'Cardo',
			'Carme' => 'Carme',
			'Carter One' => 'Carter One',
			'Caudex' => 'Caudex',
			'Cedarville Cursive' => 'Cedarville Cursive',
			'Ceviche One' => 'Ceviche One',
			'Changa One' => 'Changa One',
			'Chango' => 'Chango',
			'Chau Philomene One' => 'Chau Philomene One',
			'Chelsea Market' => 'Chelsea Market',
			'Chenla' => 'Chenla',
			'Cherry Cream Soda' => 'Cherry Cream Soda',
			'Chewy' => 'Chewy',
			'Chicle' => 'Chicle',
			'Chivo' => 'Chivo',
			'Coda' => 'Coda',
			'Coda Caption' => 'Coda Caption',
			'Codystar' => 'Codystar',
			'Comfortaa' => 'Comfortaa',
			'Coming Soon' => 'Coming Soon',
			'Concert One' => 'Concert One',
			'Condiment' => 'Condiment',
			'Content' => 'Content',
			'Contrail One' => 'Contrail One',
			'Convergence' => 'Convergence',
			'Cookie' => 'Cookie',
			'Copse' => 'Copse',
			'Corben' => 'Corben',
			'Cousine' => 'Cousine',
			'Coustard' => 'Coustard',
			'Covered By Your Grace' => 'Covered By Your Grace',
			'Crafty Girls' => 'Crafty Girls',
			'Creepster' => 'Creepster',
			'Crete Round' => 'Crete Round',
			'Crimson Text' => 'Crimson Text',
			'Crushed' => 'Crushed',
			'Cuprum' => 'Cuprum',
			'Cutive' => 'Cutive',
			'Damion' => 'Damion',
			'Dancing Script' => 'Dancing Script',
			'Dangrek' => 'Dangrek',
			'Dawning of a New Day' => 'Dawning of a New Day',
			'Days One' => 'Days One',
			'Delius' => 'Delius',
			'Delius Swash Caps' => 'Delius Swash Caps',
			'Delius Unicase' => 'Delius Unicase',
			'Della Respira' => 'Della Respira',
			'Devonshire' => 'Devonshire',
			'Didact Gothic' => 'Didact Gothic',
			'Diplomata' => 'Diplomata',
			'Diplomata SC' => 'Diplomata SC',
			'Doppio One' => 'Doppio One',
			'Dorsa' => 'Dorsa',
			'Dosis' => 'Dosis',
			'Dr Sugiyama' => 'Dr Sugiyama',
			'Droid Sans' => 'Droid Sans',
			'Droid Sans Mono' => 'Droid Sans Mono',
			'Droid Serif' => 'Droid Serif',
			'Duru Sans' => 'Duru Sans',
			'Dynalight' => 'Dynalight',
			'EB Garamond' => 'EB Garamond',
			'Eater' => 'Eater',
			'Economica' => 'Economica',
			'Electrolize' => 'Electrolize',
			'Emblema One' => 'Emblema One',
			'Emilys Candy' => 'Emilys Candy',
			'Engagement' => 'Engagement',
			'Enriqueta' => 'Enriqueta',
			'Erica One' => 'Erica One',
			'Esteban' => 'Esteban',
			'Euphoria Script' => 'Euphoria Script',
			'Ewert' => 'Ewert',
			'Exo' => 'Exo',
			'Exo 2' => 'Exo 2',
			'Expletus Sans' => 'Expletus Sans',
			'Fanwood Text' => 'Fanwood Text',
			'Fascinate' => 'Fascinate',
			'Fascinate Inline' => 'Fascinate Inline',
			'Federant' => 'Federant',
			'Federo' => 'Federo',
			'Felipa' => 'Felipa',
			'Fjord One' => 'Fjord One',
			'Flamenco' => 'Flamenco',
			'Flavors' => 'Flavors',
			'Fondamento' => 'Fondamento',
			'Fontdiner Swanky' => 'Fontdiner Swanky',
			'Forum' => 'Forum',
			'Fjalla One' => 'Fjalla One',
			'Francois One' => 'Francois One',
			'Fredericka the Great' => 'Fredericka the Great',
			'Fredoka One' => 'Fredoka One',
			'Freehand' => 'Freehand',
			'Fresca' => 'Fresca',
			'Frijole' => 'Frijole',
			'Fugaz One' => 'Fugaz One',
			'GFS Didot' => 'GFS Didot',
			'GFS Neohellenic' => 'GFS Neohellenic',
			'Galdeano' => 'Galdeano',
			'Gentium Basic' => 'Gentium Basic',
			'Gentium Book Basic' => 'Gentium Book Basic',
			'Geo' => 'Geo',
			'Geostar' => 'Geostar',
			'Geostar Fill' => 'Geostar Fill',
			'Germania One' => 'Germania One',
			'Gilda Display' => 'Gilda Display',
			'Give You Glory' => 'Give You Glory',
			'Glass Antiqua' => 'Glass Antiqua',
			'Glegoo' => 'Glegoo',
			'Gloria Hallelujah' => 'Gloria Hallelujah',
			'Goblin One' => 'Goblin One',
			'Gochi Hand' => 'Gochi Hand',
			'Gorditas' => 'Gorditas',
			'Goudy Bookletter 1911' => 'Goudy Bookletter 1911',
			'Graduate' => 'Graduate',
			'Gravitas One' => 'Gravitas One',
			'Great Vibes' => 'Great Vibes',
			'Gruppo' => 'Gruppo',
			'Gudea' => 'Gudea',
			'Habibi' => 'Habibi',
			'Hammersmith One' => 'Hammersmith One',
			'Handlee' => 'Handlee',
			'Hanuman' => 'Hanuman',
			'Happy Monkey' => 'Happy Monkey',
			'Henny Penny' => 'Henny Penny',
			'Herr Von Muellerhoff' => 'Herr Von Muellerhoff',
			'Holtwood One SC' => 'Holtwood One SC',
			'Homemade Apple' => 'Homemade Apple',
			'Homenaje' => 'Homenaje',
			'IM Fell DW Pica' => 'IM Fell DW Pica',
			'IM Fell DW Pica SC' => 'IM Fell DW Pica SC',
			'IM Fell Double Pica' => 'IM Fell Double Pica',
			'IM Fell Double Pica SC' => 'IM Fell Double Pica SC',
			'IM Fell English' => 'IM Fell English',
			'IM Fell English SC' => 'IM Fell English SC',
			'IM Fell French Canon' => 'IM Fell French Canon',
			'IM Fell French Canon SC' => 'IM Fell French Canon SC',
			'IM Fell Great Primer' => 'IM Fell Great Primer',
			'IM Fell Great Primer SC' => 'IM Fell Great Primer SC',
			'Iceberg' => 'Iceberg',
			'Iceland' => 'Iceland',
			'Imprima' => 'Imprima',
			'Inconsolata' => 'Inconsolata',
			'Inder' => 'Inder',
			'Indie Flower' => 'Indie Flower',
			'Inika' => 'Inika',
			'Irish Grover' => 'Irish Grover',
			'Istok Web' => 'Istok Web',
			'Italiana' => 'Italiana',
			'Italianno' => 'Italianno',
			'Jim Nightshade' => 'Jim Nightshade',
			'Jockey One' => 'Jockey One',
			'Jolly Lodger' => 'Jolly Lodger',
			'Josefin Sans' => 'Josefin Sans',
			'Josefin Slab' => 'Josefin Slab',
			'Judson' => 'Judson',
			'Julee' => 'Julee',
			'Junge' => 'Junge',
			'Jura' => 'Jura',
			'Just Another Hand' => 'Just Another Hand',
			'Just Me Again Down Here' => 'Just Me Again Down Here',
			'Kameron' => 'Kameron',
			'Karla' => 'Karla',
			'Kaushan Script' => 'Kaushan Script',
			'Kelly Slab' => 'Kelly Slab',
			'Kenia' => 'Kenia',
			'Khmer' => 'Khmer',
			'Knewave' => 'Knewave',
			'Kotta One' => 'Kotta One',
			'Koulen' => 'Koulen',
			'Kranky' => 'Kranky',
			'Kreon' => 'Kreon',
			'Kristi' => 'Kristi',
			'Krona One' => 'Krona One',
			'La Belle Aurore' => 'La Belle Aurore',
			'Lancelot' => 'Lancelot',
			'Lato' => 'Lato',
			'League Script' => 'League Script',
			'Leckerli One' => 'Leckerli One',
			'Ledger' => 'Ledger',
			'Lekton' => 'Lekton',
			'Lemon' => 'Lemon',
			'Libre Baskerville' => 'Libre Baskerville',
			'Lilita One' => 'Lilita One',
			'Limelight' => 'Limelight',
			'Linden Hill' => 'Linden Hill',
			'Lobster' => 'Lobster',
			'Lobster Two' => 'Lobster Two',
			'Londrina Outline' => 'Londrina Outline',
			'Londrina Shadow' => 'Londrina Shadow',
			'Londrina Sketch' => 'Londrina Sketch',
			'Londrina Solid' => 'Londrina Solid',
			'Lora' => 'Lora',
			'Love Ya Like A Sister' => 'Love Ya Like A Sister',
			'Loved by the King' => 'Loved by the King',
			'Lovers Quarrel' => 'Lovers Quarrel',
			'Luckiest Guy' => 'Luckiest Guy',
			'Lusitana' => 'Lusitana',
			'Lustria' => 'Lustria',
			'Macondo' => 'Macondo',
			'Macondo Swash Caps' => 'Macondo Swash Caps',
			'Magra' => 'Magra',
			'Maiden Orange' => 'Maiden Orange',
			'Mako' => 'Mako',
			'Marcellus' => 'Marcellus',
			'Marcellus SC' => 'Marcellus SC',
			'Marck Script' => 'Marck Script',
			'Marko One' => 'Marko One',
			'Marmelad' => 'Marmelad',
			'Marvel' => 'Marvel',
			'Mate' => 'Mate',
			'Mate SC' => 'Mate SC',
			'Maven Pro' => 'Maven Pro',
			'Meddon' => 'Meddon',
			'MedievalSharp' => 'MedievalSharp',
			'Medula One' => 'Medula One',
			'Megrim' => 'Megrim',
			'Merienda One' => 'Merienda One',
			'Merriweather' => 'Merriweather',
			'Metal' => 'Metal',
			'Metamorphous' => 'Metamorphous',
			'Metrophobic' => 'Metrophobic',
			'Michroma' => 'Michroma',
			'Miltonian' => 'Miltonian',
			'Miltonian Tattoo' => 'Miltonian Tattoo',
			'Miniver' => 'Miniver',
			'Miss Fajardose' => 'Miss Fajardose',
			'Modern Antiqua' => 'Modern Antiqua',
			'Molengo' => 'Molengo',
			'Monofett' => 'Monofett',
			'Monoton' => 'Monoton',
			'Monsieur La Doulaise' => 'Monsieur La Doulaise',
			'Montaga' => 'Montaga',
			'Montez' => 'Montez',
			'Montserrat' => 'Montserrat',
			'Montserrat Alternates' => 'Montserrat Alternates',
			'Montserrat Subrayada' => 'Montserrat Subrayada',
			'Moul' => 'Moul',
			'Moulpali' => 'Moulpali',
			'Mountains of Christmas' => 'Mountains of Christmas',
			'Mr Bedfort' => 'Mr Bedfort',
			'Mr Dafoe' => 'Mr Dafoe',
			'Mr De Haviland' => 'Mr De Haviland',
			'Mrs Saint Delafield' => 'Mrs Saint Delafield',
			'Mrs Sheppards' => 'Mrs Sheppards',
			'Muli' => 'Muli',
			'Mystery Quest' => 'Mystery Quest',
			'Neucha' => 'Neucha',
			'Neuton' => 'Neuton',
			'News Cycle' => 'News Cycle',
			'Niconne' => 'Niconne',
			'Nixie One' => 'Nixie One',
			'Nobile' => 'Nobile',
			'Nokora' => 'Nokora',
			'Norican' => 'Norican',
			'Nosifer' => 'Nosifer',
			'Nothing You Could Do' => 'Nothing You Could Do',
			'Noticia Text' => 'Noticia Text',
			'Noto Sans' => 'Noto Sans',
			'Nova Cut' => 'Nova Cut',
			'Nova Flat' => 'Nova Flat',
			'Nova Mono' => 'Nova Mono',
			'Nova Oval' => 'Nova Oval',
			'Nova Round' => 'Nova Round',
			'Nova Script' => 'Nova Script',
			'Nova Slim' => 'Nova Slim',
			'Nova Square' => 'Nova Square',
			'Numans' => 'Numans',
			'Nunito' => 'Nunito',
			'Odor Mean Chey' => 'Odor Mean Chey',
			'Old Standard TT' => 'Old Standard TT',
			'Oldenburg' => 'Oldenburg',
			'Oleo Script' => 'Oleo Script',
			'Open Sans' => 'Open Sans',
			'Open Sans Condensed' => 'Open Sans Condensed',
			'Orbitron' => 'Orbitron',
			'Original Surfer' => 'Original Surfer',
			'Oswald' => 'Oswald',
			'Over the Rainbow' => 'Over the Rainbow',
			'Overlock' => 'Overlock',
			'Overlock SC' => 'Overlock SC',
			'Ovo' => 'Ovo',
			'Oxygen' => 'Oxygen',
			'PT Mono' => 'PT Mono',
			'PT Sans' => 'PT Sans',
			'PT Sans Caption' => 'PT Sans Caption',
			'PT Sans Narrow' => 'PT Sans Narrow',
			'PT Serif' => 'PT Serif',
			'PT Serif Caption' => 'PT Serif Caption',
			'Pacifico' => 'Pacifico',
			'Parisienne' => 'Parisienne',
			'Passero One' => 'Passero One',
			'Passion One' => 'Passion One',
			'Patrick Hand' => 'Patrick Hand',
			'Patua One' => 'Patua One',
			'Paytone One' => 'Paytone One',
			'Permanent Marker' => 'Permanent Marker',
			'Petrona' => 'Petrona',
			'Philosopher' => 'Philosopher',
			'Piedra' => 'Piedra',
			'Pinyon Script' => 'Pinyon Script',
			'Plaster' => 'Plaster',
			'Play' => 'Play',
			'Playball' => 'Playball',
			'Playfair Display' => 'Playfair Display',
			'Podkova' => 'Podkova',
			'Poiret One' => 'Poiret One',
			'Poller One' => 'Poller One',
			'Poly' => 'Poly',
			'Pompiere' => 'Pompiere',
			'Pontano Sans' => 'Pontano Sans',
			'Poppins' => 'Poppins',
			'Port Lligat Sans' => 'Port Lligat Sans',
			'Port Lligat Slab' => 'Port Lligat Slab',
			'Prata' => 'Prata',
			'Preahvihear' => 'Preahvihear',
			'Press Start 2P' => 'Press Start 2P',
			'Princess Sofia' => 'Princess Sofia',
			'Prociono' => 'Prociono',
			'Prosto One' => 'Prosto One',
			'Puritan' => 'Puritan',
			'Quantico' => 'Quantico',
			'Quattrocento' => 'Quattrocento',
			'Quattrocento Sans' => 'Quattrocento Sans',
			'Questrial' => 'Questrial',
			'Quicksand' => 'Quicksand',
			'Qwigley' => 'Qwigley',
			'Radley' => 'Radley',
			'Raleway' => 'Raleway',
			'Rammetto One' => 'Rammetto One',
			'Rancho' => 'Rancho',
			'Rationale' => 'Rationale',
			'Redressed' => 'Redressed',
			'Reenie Beanie' => 'Reenie Beanie',
			'Revalia' => 'Revalia',
			'Ribeye' => 'Ribeye',
			'Ribeye Marrow' => 'Ribeye Marrow',
			'Righteous' => 'Righteous',
			'Roboto' => 'Roboto',
			'Roboto Sans' => 'Roboto Sans',
			'Roboto Condensed' => 'Roboto Condensed',
			'Roboto Slab' => 'Roboto Slab',
			'Rochester' => 'Rochester',
			'Rock Salt' => 'Rock Salt',
			'Rokkitt' => 'Rokkitt',
			'Ropa Sans' => 'Ropa Sans',
			'Rosario' => 'Rosario',
			'Rosarivo' => 'Rosarivo',
			'Rouge Script' => 'Rouge Script',
			'Ruda' => 'Ruda',
			'Ruge Boogie' => 'Ruge Boogie',
			'Ruluko' => 'Ruluko',
			'Rum Raisin' => 'Rum Raisin',
			'Ruslan Display' => 'Ruslan Display',
			'Russo One' => 'Russo One',
			'Ruthie' => 'Ruthie',
			'Sacramento' => 'Sacramento',
			'Sail' => 'Sail',
			'Salsa' => 'Salsa',
			'Sancreek' => 'Sancreek',
			'Sansita One' => 'Sansita One',
			'Sarina' => 'Sarina',
			'Satisfy' => 'Satisfy',
			'Schoolbell' => 'Schoolbell',
			'Seaweed Script' => 'Seaweed Script',
			'Sevillana' => 'Sevillana',
			'Seymour One' => 'Seymour One',
			'Shadows Into Light' => 'Shadows Into Light',
			'Shadows Into Light Two' => 'Shadows Into Light Two',
			'Shanti' => 'Shanti',
			'Share' => 'Share',
			'Shojumaru' => 'Shojumaru',
			'Short Stack' => 'Short Stack',
			'Siemreap' => 'Siemreap',
			'Sigmar One' => 'Sigmar One',
			'Signika' => 'Signika',
			'Signika Negative' => 'Signika Negative',
			'Simonetta' => 'Simonetta',
			'Sirin Stencil' => 'Sirin Stencil',
			'Six Caps' => 'Six Caps',
			'Slackey' => 'Slackey',
			'Smokum' => 'Smokum',
			'Smythe' => 'Smythe',
			'Sniglet' => 'Sniglet',
			'Snippet' => 'Snippet',
			'Sofia' => 'Sofia',
			'Sonsie One' => 'Sonsie One',
			'Sorts Mill Goudy' => 'Sorts Mill Goudy',
			'Special Elite' => 'Special Elite',
			'Spicy Rice' => 'Spicy Rice',
			'Spinnaker' => 'Spinnaker',
			'Spirax' => 'Spirax',
			'Squada One' => 'Squada One',
			'Stardos Stencil' => 'Stardos Stencil',
			'Stint Ultra Condensed' => 'Stint Ultra Condensed',
			'Stint Ultra Expanded' => 'Stint Ultra Expanded',
			'Stoke' => 'Stoke',
			'Sue Ellen Francisco' => 'Sue Ellen Francisco',
			'Sunshiney' => 'Sunshiney',
			'Supermercado One' => 'Supermercado One',
			'Suwannaphum' => 'Suwannaphum',
			'Swanky and Moo Moo' => 'Swanky and Moo Moo',
			'Syncopate' => 'Syncopate',
			'Tangerine' => 'Tangerine',
			'Taprom' => 'Taprom',
			'Telex' => 'Telex',
			'Tenor Sans' => 'Tenor Sans',
			'The Girl Next Door' => 'The Girl Next Door',
			'Tienne' => 'Tienne',
			'Tinos' => 'Tinos',
			'Titan One' => 'Titan One',
			'Titillium Web' => 'Titillium Web',
			'Trade Winds' => 'Trade Winds',
			'Trocchi' => 'Trocchi',
			'Trochut' => 'Trochut',
			'Trykker' => 'Trykker',
			'Tulpen One' => 'Tulpen One',
			'Ubuntu' => 'Ubuntu',
			'Ubuntu Condensed' => 'Ubuntu Condensed',
			'Ubuntu Mono' => 'Ubuntu Mono',
			'Ultra' => 'Ultra',
			'Uncial Antiqua' => 'Uncial Antiqua',
			'UnifrakturCook' => 'UnifrakturCook',
			'UnifrakturMaguntia' => 'UnifrakturMaguntia',
			'Unkempt' => 'Unkempt',
			'Unlock' => 'Unlock',
			'Unna' => 'Unna',
			'VT323' => 'VT323',
			'Varela' => 'Varela',
			'Varela Round' => 'Varela Round',
			'Vast Shadow' => 'Vast Shadow',
			'Vibur' => 'Vibur',
			'Vidaloka' => 'Vidaloka',
			'Viga' => 'Viga',
			'Voces' => 'Voces',
			'Volkhov' => 'Volkhov',
			'Vollkorn' => 'Vollkorn',
			'Voltaire' => 'Voltaire',
			'Waiting for the Sunrise' => 'Waiting for the Sunrise',
			'Wallpoet' => 'Wallpoet',
			'Walter Turncoat' => 'Walter Turncoat',
			'Wellfleet' => 'Wellfleet',
			'Wire One' => 'Wire One',
			'Yanone Kaffeesatz' => 'Yanone Kaffeesatz',
			'Yellowtail' => 'Yellowtail',
			'Yeseva One' => 'Yeseva One',
			'Yesteryear' => 'Yesteryear',
			'Zeyada' => 'Zeyada'
			);
/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/
	// Set the Options Array
$attribute_array      = array();
$attribute_taxonomies = function_exists('wc_get_attribute_taxonomies')?wc_get_attribute_taxonomies():false;
if ( $attribute_taxonomies ) {
	foreach ( $attribute_taxonomies as $tax ) {
		if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
			$attribute_array[ wc_attribute_taxonomy_name( $tax->attribute_name ) ] = $tax->attribute_name;
		}
	}
}
global $of_options;
$prefix="olam";
$of_options = array();
$of_options[] = array( 
	"name" 		=> esc_html__("General Settings","olam"),
	"type" 		=> "heading"
	);
$of_options[] = array( 
	"name" 		=> esc_html__("Theme Logo","olam"),
	"desc"		=> esc_html__("Please Upload theme logo.","olam"),
	"id" 		=> $prefix."_theme_logo",
	'std'       => 'http://themes.layero.com/olamwp2/wp-content/uploads/2016/03/logo2-1.png',
	"type" 		=> 'upload'
	);
$of_options[] = array( 
	"name" 		=>  esc_html__("Theme Retina Logo","olam"),
	"desc"		=>  esc_html__("Please Upload theme logo retina logo(leave blank if not required).","olam"),
	"id" 		=>  $prefix."_theme_retina_logo",
	'std'       => 'http://themes.layero.com/olamwp2/wp-content/uploads/2016/03/retina-2.png',
	"type" 		=>  "upload"
	);
$of_options[] = array( 
	"name" 		=> esc_html__("Theme Favicon","olam"),
	"desc" 		=> esc_html__("Please Upload theme Favicon.","olam"),
	"id" 		=> $prefix."_theme_favicon",
	'std'	    => 'http://themes.layero.com/olamwp2/wp-content/uploads/2016/03/fav-1.png',
	"type" 		=> "upload");
$of_options[] = array( 
	"name" 		=> esc_html__("Theme Primary color","olam"),
	"desc" 		=> esc_html__("Please Select Theme Primary color.","olam"),
	"id" 		=> $prefix."_theme_pri_color",
	"std" 		=> "#0ad2ad",
	"type" 		=> "color");
$of_options[] = array( 
	"name" 		=> esc_html__("Theme secondary color","olam"),
	"desc" 		=> esc_html__("Please Select Theme secondary color.","olam"),
	"id" 		=> $prefix."_theme_sec_color",
	"std" 		=> "#ffd400",
	"type" 		=> "color");
$of_options[] = array( 
	"name" 		=> esc_html__("Header background color","olam"),
	"desc" 		=> esc_html__("Please Select color for header/menu background.","olam"),
	"id" 		=> $prefix."_header_bg_color",
	"std" 		=> "#1c2326",
	"type" 		=> "color");
$of_options[] = array(
	"name" 		=> esc_html__("Theme Styles","olam"),
	"type" 		=> "heading",
	);
$of_options[] = array(
	"name" 		=> esc_html__("Enable Dark Style","olam"),
	"desc" 		=> esc_html__("Check this to enable Dark-Style.","olam"),
	"id" 		=> $prefix."_dark_style",
	"type" 		=> "checkbox",
	);
$of_options[] = array( 
	"name" 		=> esc_html__("Choose Style","olam"),
	"desc" 		=> esc_html__("Select style","olam"),
	"id" => $prefix."_theme_style",
	"std" => "Style 1",
	"type" => "select",
	"options" => array(
		'1'=>__("Style 1","olam"),
		'2'=>__("Style 2","olam"),
		'3'=>__("Style 3","olam"),
		)
	); 
$of_options[] = array( 
	"name" 		=> esc_html__("No. of product columns","olam"),
	"desc" 		=> esc_html__("Select no. of product columns to display on shop and category pages of EDD.","olam"),
	"id" => $prefix."_edd_columns",
	"std" => "3 columns",
	"type" => "select",
	"options" => array(
		'2'=>__("2 columns","olam"),
		'3'=>__("3 columns","olam"),
		'4'=>__("4 columns","olam"),
		)
	); 
$of_options[] = array(
	"name" 		=> esc_html__("Align Menu Logo Center","olam"),
	"desc" 		=> esc_html__("Check this to align menu and logo centered.","olam"),
	"id" 		=> $prefix."_logo_center",
	"type" 		=> "checkbox",
	);
$of_options[] = array(
	"name" 		=> esc_html__("Enable Sticky Header","olam"),
	"desc" 		=> esc_html__("Check this to make the header a sticky header","olam"),
	"id" 		=> $prefix."_header_sticky",
	"type" 		=> "checkbox",
	);
$of_options[] = array( 
	"name" 		=> esc_html__("Theme Page Header Banner","olam"),
	"desc" 		=> esc_html__("Please Select Theme Page Header Banner.","olam"),
	"id" 		=> $prefix."_page_banner",
	'std'		=> 'http://www.outcrafter.com/olamwp4/wp-content/uploads/2016/02/olam-banner-inner.jpg',
	"type" 		=> "upload");
$of_options[] = array(
	"name" 		=> esc_html__("Enable Retina Images","olam"),
	"desc" 		=> esc_html__("Check to enable retina display for your theme. Additional retina images for each image size will be formed in the uploads folder","olam"),
	"id" 		=> "theme_retina",
	"type" 		=> "checkbox",
	);
$of_options[] = array(
	"name" 		=> esc_html__("Enable Preloader","olam"),
	"desc" 		=> esc_html__("Check to Preloader for the theme","olam"),
	"id" 		=> "olam_theme_preloader",
	'std'       => 1,
	"type" 		=> "checkbox",
	);
$of_options[] = array( 
	"name" 		=> esc_html__("Preloader image","olam"),
	"desc" 		=> esc_html__("Please Upload an image for preloader","olam"),
	"id" 		=> "olam_theme_preloader_img",
	'std'	    => '',
	'type' 		=> 'upload',
	);
$of_options[] = array(
	"name" 		=> esc_html__("Enable Categories Dropdown in header search","olam"),
	"desc" 		=> esc_html__("Check to Enable Categories Dropdown in header search","olam"),
	"id" 		=> $prefix."_category_filter",
	'std'       => 1,
	"type" 		=> "checkbox",
	);
$of_options[] = array(
	"name" 		=> esc_html__("Hide price and icons in download listings","olam"),
	"desc" 		=> esc_html__("Check this to hide the price and download, view and add to cart icons in the product listing box","olam"),
	"id" 		=> $prefix."_hide_price_details",
	'std'       => 0,
	"type" 		=> "checkbox",
	);
$of_options[] = array(
	"name" 		=> esc_html__("Hide icons in download listings","olam"),
	"desc" 		=> esc_html__("Check this to hide the download, view and add to cart icons in the product listing box","olam"),
	"id" 		=> $prefix."_hide_details",
	'std'       => 0,
	"type" 		=> "checkbox",
	);
$of_options[] = array(
	"name" 		=> esc_html__("Display categories instead of By:Author name","olam"),
	"desc" 		=> esc_html__("Check this to display category name of the download instead of the author name in listing pages","olam"),
	"id" 		=> $prefix."_show_cats",
	'std'       => 0,
	"type" 		=> "checkbox",
	);
$of_options[] = array( 	
	"name" 		=> esc_html__("Custom Product Count","olam"),
	"desc" 		=> esc_html__("Enter the number of products to be displayed in a page","olam"),
	"id" 		=> "olam_product_count",
	"type" 		=> "text",
	);
$of_options[] = array(
	"name" 		=> esc_html__("Typography","olam"),
	"type" 		=> "heading",
	"icon"		=> ADMIN_IMAGES . "icon-docs.png"
	);
$of_options[] = array( 
	"name" 		=> esc_html__("Heading Fonts","olam"),
	"desc" 		=> esc_html__("Select heading fonts","olam"),
	"id" 		=> $prefix."_headfont",
	"std" 		=> "Montserrat",
	"type" 		=> "select_google_font",
	"preview" 	=> array(
					"text" => esc_html__("This is my preview text!","olam"), //this is the text from preview box
					"size" => "30px" //this is the text size from preview box
					),
	"options" 	=> $fonts
	);
$of_options[] = array( 
	"name" 		=> esc_html__("Heading Color","olam"),
	"desc" 		=> esc_html__("Please Select heading text color","olam"),
	"id" 		=> $prefix."_headcolor",
	'std'		=> '#1e1e1e',
	"type" 		=> "color"
	);
	// 	----------------------------------------------------
	//	===============	  	body typography 	============
	//	----------------------------------------------------
$of_options[] = array( 
	"name" => esc_html__("Body Typography","olam"),
	"desc" => esc_html__("Please Select Your body Color.","olam"),
	"id" => $prefix."_bodycolor",
	"std" => "#6b6b6b",
	"type" => "color"
	);
$of_options[] = array( 
	"name" 		=> "",
	"desc" 		=> esc_html__("Select the body font","olam"),
	"id" 		=> $prefix."_bodyfont",
	"std" 		=> "Roboto",
	"type" 		=> "select_google_font",
	"preview" 	=> array(
					"text" => esc_html__("This is my preview text!","olam"), //this is the text from preview box
					"size" => "30px" //this is the text size from preview box
					),
	"options" 	=> $fonts
	);
$of_options[] = array( 
	"name" => "",
	"desc" => esc_html__("Choose body  size","olam"),
	"id" => $prefix."_bodysize",
	"std" => "14",
	"type" => "select",
	"options" => $fontsize
	); 
	// 	----------------------------------------------------
	//	===============	  	h1 typography 	================
	//	----------------------------------------------------
$of_options[] = array( 
	"name" => esc_html__("H1 Size","olam"),
	"desc" => esc_html__("Choose h1  size","olam"),
	"id" => $prefix."_h1size",
	"std" => "54",
	"type" => "select",
	"options" => $fontsize
	); 
	// 	----------------------------------------------------
	//	===============	  	h2 typography 	================
	//	----------------------------------------------------
$of_options[] = array( 
	"name" => esc_html__("H2 size","olam"),
	"desc" => esc_html__("H2 size","olam"),
	"id" => $prefix."_h2size",
	"std" => "40",
	"type" => "select",
	"options" => $fontsize
	); 
	// 	----------------------------------------------------
	//	===============	  	h3 typography 	================
	//	----------------------------------------------------
$of_options[] = array( 
	"name" => esc_html__("H3 size","olam"),
	"desc" => esc_html__("H3 size","olam"),
	"id" => $prefix."_h3size",
	"std" => "28",
	"type" => "select",
	"options" => $fontsize
	); 
	// 	----------------------------------------------------
	//	===============	  	h4 typography 	================
	//	----------------------------------------------------
$of_options[] = array( 
	"name" => esc_html__("H4 size","olam"),
	"desc" => esc_html__("H4 size","olam"),
	"id" => $prefix."_h4size",
	"std" => "20",
	"type" => "select",
	"options" => $fontsize
	); 
	// 	----------------------------------------------------
	//	===============	  	h5 typography 	================
	//	----------------------------------------------------
$of_options[] = array( 
	"name" => esc_html__("H5 size","olam"),
	"desc" => esc_html__("H5 size","olam"),
	"id" => $prefix."_h5size",
	"std" => "14",
	"type" => "select",
	"options" => $fontsize
	); 
	// 	----------------------------------------------------
	//	================	h6 Typography 	================
	//	----------------------------------------------------
$of_options[] = array( 
	"name" => esc_html__("H6 size","olam"),
	"desc" => esc_html__("H6 size","olam"),
	"id" => $prefix."_h6size",
	"std" => "12",
	"type" => "select",
	"options" => $fontsize
	); 
	// 	----------------------------------------------------
	//	=============	  Advanced Settings 	============
	//	----------------------------------------------------
$of_options[] = array( 	
	"name" 		=> esc_html__("Social","olam"),
	"type" 		=> "heading",	
	"icon"		=> ADMIN_IMAGES . "icon-settings.png"
	);
													
$of_options[] = array( 	
	"name" 		=> esc_html__("Facebook URL","olam"),
	"desc" 		=> esc_html__("Facebook URL","olam"),
	"id" 		=> $prefix."_fb_url",
	'std'		=> 'http://facebook.com/',
	"type" 		=> "text",
	);
$of_options[] = array( 	
	"name" 		=> esc_html__("Twitter URL","olam"),
	"desc" 		=> esc_html__("Twitter URL","olam"),
	"id" 		=> $prefix."_twitter_url",
	'std'		=> 'http://twitter.com/',
	"type" 		=> "text",
	);
$of_options[] = array( 	
	"name" 		=> esc_html__("LinkedIn URL","olam"),
	"desc" 		=> esc_html__("LinkedIn URL","olam"),
	"id" 		=> $prefix."_linkedin_url",
	'std'		=> '#',
	"type" 		=> "text",
	);
$of_options[] = array( 	
	"name" 		=> esc_html__("Youtube URL","olam"),
	"desc" 		=> esc_html__("Youtube URL","olam"),
	"id" 		=> $prefix."_youtube_url",
	'std'		=> '#',
	"type" 		=> "text",
	);
$of_options[] = array( 	
	"name" 		=> esc_html__("Google Plus URL","olam"),
	"desc" 		=> esc_html__("Google Plus URL","olam"),
	"id" 		=> $prefix."_googleplus_url",
	'std'		=> '#',
	"type" 		=> "text",
	);
$of_options[] = array( 	
	"name" 		=> esc_html__("Instagram URL","olam"),
	"desc" 		=> esc_html__("Instagram URL","olam"),
	"id" 		=> $prefix."_instagram_url",
	'std'		=> '#',
	"type" 		=> "text",
	);
$of_options[] = array( 	
	"name" 		=> esc_html__("Pinterest URL","olam"),
	"desc" 		=> esc_html__("Pinterest URL","olam"),
	"id" 		=> $prefix."_pinterest_url",
	'std'		=> '#',
	"type" 		=> "text",
	);
		// Footer Options
$of_options[] = array( 	
	"name" 		=> esc_html__("Miscellaneous","olam"),
	"type" 		=> "heading",
	"icon"		=> ADMIN_IMAGES . "icon-settings.png"
	);
$of_options[] = array( 	
	"name" 		=> esc_html__("Custom Css","olam"),
	"desc" 		=> esc_html__("Custom Css","olam"),
	"id" 		=> $prefix."_custom_css",
	"type" 		=> "textarea",
	);

$of_options[] = array( 	
	"name" 		=> esc_html__("From Email","olam"),
	"desc" 		=> esc_html__("From Email Address","olam"),
	"id" 		=> $prefix."_from_email",
	"type" 		=> "text",
	);


// Footer Options
$of_options[] = array( 	
	"name" 		=> esc_html__("Footer Options","olam"),
	"type" 		=> "heading",
	"icon"		=> ADMIN_IMAGES . "icon-slider.png"
	);
$of_options[] = array( 	
	"name" 		=> esc_html__("Footer Copyright Text","olam"),
	"desc" 		=> esc_html__("Footer Copyright Text","olam"),
	"id" 		=> $prefix."_footer_copy",
	'std'		=> 'All Rights reserved',
	"type" 		=> "text",
	);
$of_options[] = array( 	
	"name" 		=> esc_html__("Footer Background Image","olam"),
	"desc" 		=> esc_html__("Footer Background Image","olam"),
	"id" 		=> $prefix."_footer_background",
	"type" 		=> "upload",
	);
$of_options[] = array( 	
	"name" 		=> esc_html__("Disable the quick contact(support) window","olam"),
	"desc" 		=> esc_html__("Disable the quick contact(support) window","olam"),
	"id" 		=> $prefix."_footer_support",
	"type" 		=> "checkbox",
	);

	// Backup Options
$of_options[] = array( 	
	"name" 		=> esc_html__("Backup Options","olam"),
	"type" 		=> "heading",
	"icon"		=> ADMIN_IMAGES . "icon-slider.png"
	);

$of_options[] = array( 	
	"name" 		=> esc_html__("Backup and Restore Options","olam"),
	"id" 		=> "of_backup",
	"std" 		=> "",
	"type" 		=> "backup",
	"desc" 		=> esc_html__('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',"olam"),
	);

$of_options[] = array( 	
	"name" 		=> esc_html__("Transfer Theme Options Data","olam"),
	"id" 		=> "of_transfer",
	"std" 		=> "",
	"type" 		=> "transfer",
	"desc" 		=> esc_html__('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',"olam"),
	);

	}//End function: of_options()
}//End chack if function exists: of_options()