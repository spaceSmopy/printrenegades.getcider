<?php
	$default_title_format = '<h1 class="breadcrumbs-custom-title">%1$s</h1>';
	$default_pagetitle_format = '<h1 class="breadcrumbs-custom-title">%1$s</h1>';
	$default_pagedesc_format = '<h1 class="breadcrumbs-custom-title">%1$s</h1>';
	$pagedesc = "";
	$title_format = apply_filters( 'page-title-format', $default_title_format );
	if ( is_home() ):
		$title = __( 'Blog', 'printrenegades' );
	elseif ( is_page() ) :
		$pagetitle = get_post_meta( get_the_ID(), "page-title", true );
		$pagedesc = get_post_meta( get_the_ID(), "page-description", true );
		if( $pagetitle != "" ){
			$title_format = apply_filters( 'page-custom-title-format', $default_pagetitle_format );
			$title = $pagetitle;
		} else {
			$title = get_the_title();
		}
	elseif( is_single() ):
		$title = get_the_title();
	elseif ( is_archive() && !is_custom_post_type() && !is_home() ):
		$title = __( 'Archives', 'printrenegades' );
		if ( is_category() ):
			$title = sprintf( __( 'Category Archives: %s', 'printrenegades' ), '<span>' . single_cat_title( '', false ) . '</span>' );
			$pagedesc = category_description();
		elseif ( is_tag() ):
			$title = sprintf( __( 'Tag Archives: %s', 'printrenegades' ), '<span>' . single_tag_title( '', false ) . '</span>' );
			$pagedesc = tag_description();
		elseif ( is_day() ):
			$title = sprintf( __( 'Daily Archives: <span>%s</span>', 'printrenegades' ), get_the_date() );
		elseif ( is_month() ):
			$title = sprintf( __( 'Monthly Archives: <span>%s</span>', 'printrenegades' ), get_the_date('F Y') );
		elseif ( is_year() ):
			$title = sprintf( __( 'Yearly Archives: <span>%s</span>', 'printrenegades' ), get_the_date('Y') );
		endif;
	elseif ( is_custom_post_type() ):

		$postType = get_queried_object();

		$title = esc_html($postType->labels->singular_name);
	elseif ( is_search() ):
		$title =  __('Search for: ', 'printrenegades') . get_search_query();
	elseif ( is_404() ):
		$title = __('404', 'printrenegades')	;
	endif;
	printf( $title_format, $title );
	if( $pagedesc != "" ){
		$pagedesc_format = apply_filters( 'page-custom-description-format', $default_pagedesc_format );
		printf( $pagedesc_format, $pagedesc );
	}
?>
