<?php

class Newsletter_Subscriber_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'nl_domain',
			'description' => 'Simple Newsletter Subscriptions',
		);
		parent::__construct( 'news_letter_widget', 'Newsletter Subscriptions', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		echo $args['before_title'];
		if(isset($instance['title'])){
			echo $instance['title'];
		}		
		echo $args['after_title'];
		

        ?>
		
			<div class="form-msg"></div>
			<form method="POST" action="<?php echo plugins_url().'/appsmo_newsletter/includes/news-letter-mailer.php'?>" id="subscriber-form">
				<div class="form-group">
					<label for="name">Name:</label><br>
					<input type="text" name="name" required class="form-control">
				</div>


				<div class="form-group">
					<label for="email">Email:</label><br>
					<input type="text" name="email" required class="form-control">
				</div>

				<input type="hidden" name="recipient" value="<?php echo $instance['recipient']; ?> ">
				<input type="hidden" name="subject" value="<?php echo $instance['subject']; ?> "><br> 
				<input type="submit" class="btn btn-primary" name="subscriber_submit" value="Sign Me Up"><br>  
			</form>
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
				'recipient' => (!empty($new_instance['recipient'])) ? strip_tags($new_instance['recipient']) : '',
				'subject' => (!empty($new_instance['subject'])) ? strip_tags($new_instance['subject']) : '',
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
        $title = !empty($instance['title']) ? $instance['title']: __('Newsletter Subscriber', "ns_domain");
        $recipient = !empty($instance['recipient']) ? $instance['recipient']: "";
        $subject = !empty($instance['subject']) ? $instance['subject']: __('You have a news subscriber', "ns_domain");
        ?>
            <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title: '); ?></label><br>
                <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" class="widefat">
            </p>

            <p>
            <label for="<?php echo $this->get_field_id('recipient'); ?>"><?php _e('Recipient: '); ?></label><br>
                <input type="text" id="<?php echo $this->get_field_id('recipient'); ?>" name="<?php echo $this->get_field_name('recipient'); ?>" value="<?php echo esc_attr($recipient); ?>" class="widefat">
            </p>

            <p>
            <label for="<?php echo $this->get_field_id('subject'); ?>"><?php _e('Subject: '); ?></label><br>
                <input type="text" id="<?php echo $this->get_field_id('subject'); ?>" name="<?php echo $this->get_field_name('subject'); ?>" value="<?php echo esc_attr($subject); ?>" class="widefat">
            </p>

        <?php
    }

  
}