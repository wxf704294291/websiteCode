<?php
/**
 * The template for displaying answers
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */

global $dwqa_general_settings;
$sort = isset( $_GET['sort'] ) ? esc_html( $_GET['sort'] ) : '';
$filter = isset( $_GET['filter'] ) ? esc_html( $_GET['filter'] ) : 'all';
?>
<div class="dwqa-question-filter">
	<span><?php _e( '过滤:', 'dwqa' ); ?></span>
	<?php if ( !isset( $_GET['user'] ) ) : ?>
		<a href="<?php echo esc_url( add_query_arg( array( 'filter' => 'all' ) ) ) ?>" class="<?php echo 'all' == $filter ? 'active' : '' ?>"><?php _e( 'All', 'dwqa' ); ?></a>
		<?php if ( dwqa_is_enable_status() ) : ?>
			<a href="<?php echo esc_url( add_query_arg( array( 'filter' => 'open' ) ) ) ?>" class="<?php echo 'open' == $filter ? 'active' : '' ?>"><?php _e( 'Open', 'dwqa' ); ?></a>
			<a href="<?php echo esc_url( add_query_arg( array( 'filter' => 'resolved' ) ) ) ?>" class="<?php echo 'resolved' == $filter ? 'active' : '' ?>"><?php _e( 'Resolved', 'dwqa' ); ?></a>
			<a href="<?php echo esc_url( add_query_arg( array( 'filter' => 'closed' ) ) ) ?>" class="<?php echo 'closed' == $filter ? 'active' : '' ?>"><?php _e( 'Closed', 'dwqa' ); ?></a>
		<?php endif; ?>
		<a href="<?php echo esc_url( add_query_arg( array( 'filter' => 'unanswered' ) ) ) ?>" class="<?php echo 'unanswered' == $filter ? 'active' : '' ?>"><?php _e( '未回答', 'dwqa' ); ?></a>
		<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( add_query_arg( array( 'filter' => 'my-questions' ) ) ) ?>" class="<?php echo 'my-questions' == $filter ? 'active' : '' ?>"><?php _e( '我的提问', 'dwqa' ); ?></a>
			<a href="<?php echo esc_url( add_query_arg( array( 'filter' => 'my-subscribes' ) ) ) ?>" class="<?php echo 'my-subscribes' == $filter ? 'active' : '' ?>"><?php _e( '我的订阅', 'dwqa' ); ?></a>
		<?php endif; ?>
	<?php else : ?>
		<a href="<?php echo esc_url( add_query_arg( array( 'filter' => 'all' ) ) ) ?>" class="<?php echo 'all' == $filter ? 'active' : '' ?>"><?php _e( 'Questions', 'dwqa' ); ?></a>
		<a href="<?php echo esc_url( add_query_arg( array( 'filter' => 'subscribes' ) ) ) ?>" class="<?php echo 'subscribes' == $filter ? 'active' : '' ?>"><?php _e( 'Subscribes', 'dwqa' ); ?></a>
	<?php endif; ?>
	<select id="dwqa-sort-by" class="dwqa-sort-by" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
		<option selected disabled><?php _e( '排序', 'dwqa' ); ?></option>
		<option <?php selected( $sort, 'views' ) ?> value="<?php echo esc_url( add_query_arg( array( 'sort' => 'views' ) ) ) ?>"><?php _e( '浏览数', 'dwqa' ) ?></option>
		<option <?php selected( $sort, 'answers' ) ?> value="<?php echo esc_url( add_query_arg( array( 'sort' => 'answers' ) ) ) ?>"><?php _e( '回答数', 'dwqa' ); ?></option>
		<option <?php selected( $sort, 'votes' ) ?> value="<?php echo esc_url( add_query_arg( array( 'sort' => 'votes' ) ) ) ?>"><?php _e( '投票数', 'dwqa' ) ?></option>
	</select>
</div>