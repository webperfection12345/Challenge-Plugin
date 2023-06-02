<?php
/*
Plugin Name: NN Challenge
Description: Battle game between player and computer.
Version: 1.0
Author: Game Author
*/

//Add a shortcode
add_shortcode('challange_game_shortcode', 'challange_game');
function challange_game() {
    ob_start();

    $units = ['Cavalry', 'Archers', 'Pikemen'];
    $player_score = 0;
    $computer_score = 0;
    $rounds = 20;

    // Display Start of game screen with unit selection
    //if (!isset($_POST['unit'])) {
        echo '<div class="form_init">';
            echo '<div class="select_player">';
                echo '<h2>Select a unit to send into battle:</h2>';
                echo '<form method="POST">';
                foreach ($units as $unit) {
                    echo '<input type="radio" name="unit" class="unit" value="' . $unit . '"> ' . $unit . '<br>';
                }
                echo '<input type="hidden" id="get_round">';
                echo '<input type="submit" id="Send_into_Battle" value="Send into Battle">';
                echo '</form>';
            
            echo '</div>';
             
   // } else {
            echo '<div class="game_result">';
                // //echo 'The number is currently ' . $number;
                // $player_unit = $_POST['unit'];
                // $computer_unit = $units[array_rand($units)];
    
                // echo '<h2>Player sent ' . $player_unit . '</h2>';
                // echo '<h2>Computer sent ' . $computer_unit . '</h2>';
    
                // if ($player_unit == $computer_unit) {
                //     echo '<h3>Both units are defeated!</h3>';
                // } elseif (
                //     ($player_unit == 'Cavalry' && $computer_unit == 'Archers') ||
                //     ($player_unit == 'Archers' && $computer_unit == 'Pikemen') ||
                //     ($player_unit == 'Pikemen' && $computer_unit == 'Cavalry')
                // ) {
                //     echo '<h3>Player wins this round!</h3>';
                //     $player_score++;
                // } else {
                //     echo '<h3>Computer wins this round!</h3>';
                //     $computer_score++;
                // }
    
                // echo '<h4>Player Score: ' . $player_score . '</h4>';
                // echo '<h4>Computer Score: ' . $computer_score . '</h4>';
        
                // if ($rounds > 1) {
                //     $rounds--;
                //     echo '<p>' . $rounds . ' rounds remaining</p>';
                //     echo '<form method="POST">';
                //     echo '<input type="hidden" name="rounds" value="'. $rounds.'">';
                //     //echo '<input type="number" id="txtNumber" name="txtNumber" min="0" value="'. $number.'">';
                //     echo '<input type="submit" value="Next Round">';
                //     echo '</form>';
                // } else {
                //     echo '<h2>Game Over!</h2>';
                //     if ($player_score > $computer_score) {
                //         echo '<h3>Player wins!</h3>';
                //     } elseif ($player_score < $computer_score) {
                //         echo '<h3>Computer wins!</h3>';
                //     } else {
                //         echo '<h3>It\'s a tie!</h3>';
                //     }
                // }
            echo '</div>';  
        
   // }
    echo '</div>';
    return ob_get_clean();
}


function game_enqueue_scripts() {
	wp_register_script('game_ajax_define', plugin_dir_url( __DIR__  )  . "nn_challenge/js/game_ajax_urls.js", array("jquery"), "", true);
    wp_localize_script('game_ajax_define', 'rating_Ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )) );
    wp_enqueue_script('game_ajax_define' );
    wp_enqueue_script( 'my_plugin_script', plugin_dir_url( __DIR__  ) . 'nn_challenge/js/game-script.js', array( 'jquery' ), '1.1.1', true );
    //wp_enqueue_style('battle-game-styles', plugins_url( '/css/styles.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'game_enqueue_scripts' );



function game_result_func(){
    //print_r($_POST);
    $player_score = 0;
    $computer_score = 0;
    $rounds = 20;
    $units = ['Cavalry', 'Archers', 'Pikemen'];
    $round_result = '';
    
    $player_unit = $_POST['unitVal'];
    $computer_unit = $units[array_rand($units)];
    echo '<div class="result_continue">';
        echo '<h2>Player sent ' . $player_unit . '</h2>';
        echo '<h2>Computer sent ' . $computer_unit . '</h2>';


                    
        if ($player_unit == $computer_unit) {
           $round_result = '<h3>Both units are defeated!</h3>';
        } elseif (
            ($player_unit == 'Cavalry' && $computer_unit == 'Archers') ||
            ($player_unit == 'Archers' && $computer_unit == 'Pikemen') ||
            ($player_unit == 'Pikemen' && $computer_unit == 'Cavalry')
        ) {
             $round_result = '<h3>Player wins this round!</h3>';
            $player_score++;
        } else {
            $round_result = '<h3>Computer wins this round!</h3>';
            $computer_score++;
        }  

        // Store round history
            $round_history[] = array(
                'player_unit' => $player_unit,
                'computer_unit' => $computer_unit,
                'result' => $round_result
            );

              echo '<h3>' . $round_result . '</h3>';
        echo '<h4>Player Score: ' . $player_score . '</h4>';
        echo '<h4>Computer Score: ' . $computer_score . '</h4>';

    //if ($rounds > 1) {
            //$rounds--;
             // Display round history
            // echo '<h3>Round History:</h3>';
            // echo '<ul>';
            // foreach ($round_history as $round) {
            //     echo '<li>';
            //     echo 'Player: ' . $round['player_unit'] . ', ';
            //     echo 'Computer: ' . $round['computer_unit'] . ', ';
            //     echo 'Result: ' . $round['result'];
            //     echo '</li>';
            // }
            // echo '</ul>';

            echo '<p class="round_countdown"></p>';
            echo '<form method="POST">';
            echo '<input type="hidden" id="oldrounds" value=>';
            echo '<input type="submit" id="next_round" value="Next Round">';
            echo '</form>';
        echo '</div>';
   // } else {
        echo '<div class="result_stop" style="display:none">';
            echo '<h2>Game Over!</h2>';
            if ($player_score > $computer_score) {
                echo '<h3>Player wins!</h3>';
            } elseif ($player_score < $computer_score) {
                echo '<h3>Computer wins!</h3>';
            } else {
                echo '<h3>It\'s a tie!</h3>';
            }
        echo '</div>'; 
   // }

    
    die();
}

add_action('wp_ajax_nopriv_game_result_func', 'game_result_func');
add_action('wp_ajax_game_result_func', 'game_result_func');