<?php

class GitHub_Widget extends WP_Widget {

	private $url;
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$this->url = "https://api.github.com/users/";
		$widget_ops = array( 
			'classname' => 'gt_domain',
			'description' => 'Github Projects',
		);
		parent::__construct( 'github_widget', 'GitHub Widgets', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

			//get and set values 	
			echo $args['before_widget'];
			

			if(isset($instance['title'])){
				$title = apply_filters('widget_title', $instance['title']);
				echo $args['before_title'].$title.$args['after_title'];
			}else{
				$title = "Chat";
			}	
			

			if(isset($instance['username'])){
				$username = esc_attr($instance['username']);
			}else{
				$username = "emodatt08";
			}

			if(isset($instance['count'])){
				$count = esc_attr($instance['count']);
			}else{
				$count = 2;
			}
		
		
			//show repos
			$repos = $this->getRepoItems($title, $username, $count);
			

        ?>

			
		<?php

		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
        //Call form function
        return $this->getForm($instance);
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
        return $this->getUpdateForm($new_instance, $old_instance);
	}

	private function getUpdateForm($new_instance, $old_instance){
		$instance = [
				'title' => (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '',
				'username' => (!empty($new_instance['username'])) ? strip_tags($new_instance['username']) : '',
				'count' => (!empty($new_instance['count'])) ? strip_tags($new_instance['count']) : '',
		];

		return $instance;
	}

    /**
     * Gets and Displays the form
     *
     * @param [type] $instance
     * @return void
     */
    private function getForm($instance){
        $title = !empty($instance['title']) ? $instance['title']: __('AppsMo Github Projects', "gt_domain");
        $username = !empty($instance['username']) ? $instance['username']: __('AppsMo Github Projects', "gt_domain");;
        $count = !empty($instance['count']) ? $instance['count']: 5;
        ?>
            <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title: '); ?></label><br>
                <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" class="widefat">
            </p>

            <p>
            <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('GitHub Username: '); ?></label><br>
                <input type="text" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo esc_attr($username); ?>" class="widefat">
            </p>

            <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Project Count: '); ?></label><br>
                <input type="text" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo esc_attr($count); ?>" >
            </p>

        <?php
    }


	/**
	 * Fetch Data With Curl
	 *
	 * @param [type] $url
	 * @return void
	 */
	public function fetch($title, $username, $count){
		$url = $this->url.$username."/repos?sort=created&per_page=".$count;
        $agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36";
 
             $curl = curl_init();
             curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
             curl_setopt($curl, CURLOPT_HEADER, false);
             curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
             curl_setopt($curl, CURLOPT_URL, $url);
             curl_setopt($curl, CURLOPT_REFERER, $url);
             //curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
             curl_setopt($curl, CURLOPT_USERAGENT, $agent);
             curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
             $response = curl_exec($curl);
             curl_close($response);
            //var_dump($str, $url); die;
             return $response;
 
         }
		 /**
		  * Get Github Repos via curls
		  *
		  * @param [type] $title
		  * @param [type] $username
		  * @param [type] $count
		  * @return void
		  */
		 private function getRepoItems($title, $username, $count){
			$repos = $this->fetch($title, $username, $count);
			if(isset($repos)){
				$repos = json_decode($repos);
				$output = '<ul class="repos"> ';

				foreach($repos as $repo){
					$output .= '<li>
					<div class="repo-title">"'.$repo->name.'" </div>
					<div class="repo-desc">"'.$repo->description.'" </div>
					<a href="'.$repo->html_url.'" target="_blank"> See More </a>
					</li>';
				}

				$output .= '</ul>';
			}


			
		 }

  
}