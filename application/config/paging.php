<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*** Customizing the Pagination for Administrator side Star	***/
	
//The number of "digit" links you would like before and after the selected page number.
//For example, the number 2 will place two digits on either side,
	$config['num_links'] = 3;

	//Number of Result per Page
	$config['per_page'] = 2;
	
	//By default, the URI segment will use the starting index for the items you are paginating. If you prefer to show the the actual page number, set this to TRUE.
	//$config['use_page_numbers'] = false;
	
/*** Adding Enclosing Markup ***/
	//If you would like to surround the entire pagination with some markup you can do it with these two prefs:
	$config['full_tag_open'] = '<ul>';
	$config['full_tag_close'] = '</ul>';

/*** Customizing the First Link ***/

	//The text you would like shown in the "first" link on the left.
	//If you do not want this link rendered, you can set its value to FALSE.
	$config['first_link'] = '&lt;&lt;';

	//The opening tag for the "first" link.
	$config['first_tag_open'] = '<li>';
	
	//The closing tag for the "first" link.
	$config['first_tag_close'] = '</li>';
	
	//Class Name of First Link
	$config['first_link_class'] = "class='page-far-left'";
	
/*** Customizing the Last Link ***/

	//The text you would like shown in the "last" link on the right.
	//If you do not want this link rendered, you can set its value to FALSE.
	//$config['last_link'] = 'Last';
	$config['last_link'] = '&gt;&gt;';
	
	//The opening tag for the "last" link.
	$config['last_tag_open'] = '<li>';
	
	//The closing tag for the "last" link.
	$config['last_tag_close'] = '</li>';

	//Class Name of First Link
	$config['last_link_class'] = "class='page-far-right'";

/***	Customizing the "Next" Link	***/

	//The text you would like shown in the "next" page link.
	//If you do not want this link rendered, you can set its value to FALSE.
	$config['next_link'] = '&gt;';
	
	//The opening tag for the "next" link.
	$config['next_tag_open'] = '<li>';
	
	//The closing tag for the "next" link.
	$config['next_tag_close'] = '</li>';

	//Class Name of First Link
	$config['next_link_class'] = "class='page-next'";

	
/*** 		Customizing the "Previous" Link	***/

	//The text you would like shown in the "previous" page link.
	//If you do not want this link rendered, you can set its value to FALSE.
	$config['prev_link'] = '&lt;';
	
	//The opening tag for the "previous" link.
	$config['prev_tag_open'] = '<li>';
	
	//The closing tag for the "previous" link.
	$config['prev_tag_close'] = '</li>';
	
	//Class Name of Prev Link
	$config['prev_link_class'] = "class='page-prev'";

/***	Customizing the "Current Page" Link	***/

	//The opening tag for the "current" link.
	$config['cur_tag_open'] = "<li class='active'><a href='".$_SERVER['REQUEST_URI']."#'>";
	
	//The closing tag for the "current" link.
	$config['cur_tag_close'] = '</a></li>';

/***	Customizing the "Digit" Link	***/

	//The opening tag for the "digit" link.
	$config['num_tag_open'] = '<li>';
	
	//The closing tag for the "digit" link.
	$config['num_tag_close'] = '</li>';

	//Class Name of First Link
	$config['num_tag_class'] = "class='page-numbered'";

/*1** Customizing the Pagination for Administrator side End	***/
