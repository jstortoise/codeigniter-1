<?php
//class popup.class.php

/**
  * PHP-Class OverallTagView Version 1.0 , released 17-NOV-2006
  * Author: Dror Golan, drorgolan@gmail.com
  *
  * License: GNU GPL (http://www.opensource.org/licenses/gpl-license.html)
  *
  * If you find it useful, you might rate it on http://www.phpclasses.org
  * If you use this class in a productional environment, you may drop me a note, so I can add a link to the page.
  *
  *
  * License: GNU GPL (http://www.opensource.org/licenses/gpl-license.html)
  *
  * This program is free software;
  *
  * you can redistribute it and/or modify it under the terms of the GNU General Public License
  * as published by the Free Software Foundation; either version 2 of the License,
  * or (at your option) any later version.
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
  * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
  *
  * You should have received a copy of the GNU General Public License along with this program;
  * if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
  *
  **/


  /**
  *  This Class output HTML src for Pop-Up messages , each Message contains 4 element :
  *  The Message , The Headline , The Text and the Control section. each section is control by
  *  an associative array which reflects the W3C styling of the element (full list can be viewed here :
  *  http://www.w3.org/TR/CSS21/propidx.html) .The Message can be closed
  *  manually by the control section element (usally a "close" lable) or automatically after a timed session.
  *  The Class is FF/IE compatible.
   
  
  */


// DEFAULT PARAMETERS
// CHANGE THIS VALUE FOR DEFAULT BEHAVIOUR (for example if you need to change the
// Allignment of the Headline , change the value of DEFAULT_HEADLINE_TEXT_ALLIGNMENT to 'left')


define('FF_OPACITY_LEVEL',0.7);
define('IE_OPACITY_LEVEL',70);
define('DEFAULT_BORDER_STYLE',"red 1px solid");
define('DEFAULT_MESSAGE_HEIGHT',220);
define('DEFAULT_MESSAGE_WIDTH',400);
define('DEFAULT_HEADLINE_TEXT_ALLIGNMENT','right');
define('DEFAULT_HEADLINE_HEIGHT_RATIO',0.2);
define('DEFAULT_HEADLINE_TEXT_COLOR','white');
define('DEFAULT_HEADLINE_BACKGROUND_COLOR','blue');
define('DEFAULT_TEXT_ALLIGNMENT','center');
define('DEFAULT_TEXT_HEIGHT_RATIO',0.7);
define('DEFAULT_TEXT_COLOR','black');
define('DEFAULT_TEXT_BACKGROUND_COLOR','aqua');
define('DEFAULT_CONTROL_TEXT_ALLIGNMENT','right');
define('DEFAULT_CONTROL_HEIGHT_RATIO',0.1);
define('DEFAULT_CONTROL_TEXT_COLOR','black');
define('DEFAULT_CONTROL_TEXT_WORDING','Close');


class popupMsg {

////////////////////////////////
	//
	//	PUBLIC PARAMS
	//

		  /**
		  * @shortdesc associative array that reflects styling values of Message
          * @type Array
		  * @public
          * @default value : DEFAULT_BORDER_STYLE : red 1px solid
                             DEFAULT_MESSAGE_HEIGHT:110
                             DEFAULT_MESSAGE_WIDTH:300
		  */
		 var $MessageStyleArr;
		 /**
		  * @shortdesc associative array that reflects styling values of Headline
          * @type Array
		  * @public
          * @default value : DEFAULT_HEADLINE_TEXT_ALLIGNMENT:'right'
							 DEFAULT_HEADLINE_HEIGHT_RATIO:0.2   // 0.2 of total MSG height
							 DEFAULT_HEADLINE_TEXT_COLOR:'white'
							 DEFAULT_HEADLINE_BACKGROUND_COLOR:'blue'
		  */
         var $HeadlineStyleArr;
		 
		 /**
		  * @shortdesc associative array that reflects styling values of Text
          * @type Array
		  * @public
          * @default value : DEFAULT_TEXT_ALLIGNMENT,'center'
						     DEFAULT_TEXT_HEIGHT_RATIO,0.7   // 0.7 of total MSG height
							 DEFAULT_TEXT_COLOR,'white'
							 DEFAULT_TEXT_BACKGROUND_COLOR,'aqua'
		  */
		 
         var $TextStyleArr;
		 
		 /**
		  * @shortdesc associative array that reflects styling values of Control
          * @type Array
		  * @public
          * @default value : DEFAULT_CONTROL_TEXT_ALLIGNMENT','right'
                             DEFAULT_CONTROL_HEIGHT_RATIO,0.1
                             DEFAULT_CONTROL_TEXT_COLOR,'black'
                             DEFAULT_CONTROL_TEXT_WORDING,'Close'
		  */
         var $ControlStyleArr;
		 /**
		  * @shortdesc Message Text
          * @type String
		  * @public
          * @default value :"Welcome to MsgPopUp Class"
		  */
         var $Text;
		 /**
		  * @shortdesc Headline Text
          * @type String
		  * @public
          * @default value :"Headline"
		  */
          var $HeadLineTxt;
		  /**
		  * @shortdesc Control Text (the wording at the bottom of message that close it)
          * @type String
		  * @public
          * @default value :"Close"
		  */
		  var $ControlTxt;
		  /**
		  * @shortdesc HTML SRC of Message
          * @type String
		  * @public
		  */	  
          var $HTML;
		  /**
		  * @shortdesc uniqe id(name) of Message element
          * @type String
		  * @public
		  */	  	  
          var $id;
		  /**
		  * @shortdesc time out (in ms) untill the message is disappeared
          * @type String
		  * @public
		  * @default value : 0  (== No Timeout)
	      */	  		  
          var $timeout;

//Constructor
function popupMsg ($top=0,$left=0,$width=DEFAULT_MESSAGE_WIDTH,$height=DEFAULT_MESSAGE_HEIGHT,$HeadlineTxt="Headline",$Msgtxt="Welcome to MsgPopUp Class",$controlTXT,$timeout=0,$MessageStyleArr='',$HeadlineStyleArr='',$TextStyleArr='',$ControlStyleArr='') {

// apply Firefox FIX 

if (strpos($_SERVER['HTTP_USER_AGENT'],'Firefox')>0) $FF_FIX=10;
else $FF_FIX=0;


if ($MessageStyleArr!='') $this->MessageStyleArr=$MessageStyleArr;
 
        if (!isset($this->MessageStyleArr["border"])) $this->MessageStyleArr["border"] = DEFAULT_BORDER_STYLE;
		if (!isset($this->MessageStyleArr["Height"])) $this->MessageStyleArr["Height"] = $height;
		if (!isset($this->MessageStyleArr["Width"]))  $this->MessageStyleArr["Width"] = $width;
	    
		
		// transparency (added 30-09-2007)
		
		if (!isset($this->MessageStyleArr["filter"])) $this->MessageStyleArr["filter"] = "alpha(opacity=".IE_OPACITY_LEVEL.")";
		if (!isset($this->MessageStyleArr["moz-opacity"])) $this->MessageStyleArr["moz-opacity"] = FF_OPACITY_LEVEL;
		if (!isset($this->MessageStyleArr["opacity"]))  $this->MessageStyleArr["opacity"] = FF_OPACITY_LEVEL;
	    
		
		
		
		# filter:alpha(opacity=60);   
#    -moz-opacity: 0.6;   
#    opacity: 0.6;   
	
	
	
	
// FF Fix 

      $this->MessageStyleArr["padding-bottom"] = $FF_FIX;	
	  
// Apply Absolute positioning parameters .

     $this->MessageStyleArr["position"] = "absolute";
     $this->MessageStyleArr["top"] = $top;
     $this->MessageStyleArr["left"] = $left;	
	
if ($HeadlineStyleArr!='') $this->HeadlineStyleArr=$HeadlineStyleArr;
 
        if (!isset($this->HeadlineStyleArr["text-align"]))       $this->HeadlineStyleArr["text-align"] = DEFAULT_HEADLINE_TEXT_ALLIGNMENT;
		if (!isset($this->HeadlineStyleArr["Height"]))           $this->HeadlineStyleArr["Height"] = $this->MessageStyleArr["Height"]*DEFAULT_HEADLINE_HEIGHT_RATIO;
		if (!isset($this->HeadlineStyleArr["Width"]))            $this->HeadlineStyleArr["Width"] = $this->MessageStyleArr["Width"]; 
		if (!isset($this->HeadlineStyleArr["color"]))            $this->HeadlineStyleArr["color"] =  DEFAULT_HEADLINE_TEXT_COLOR; 
		if (!isset($this->HeadlineStyleArr["background-color"])) $this->HeadlineStyleArr["background-color"] = DEFAULT_HEADLINE_BACKGROUND_COLOR; 
		
		
if ($TextStyleArr!='') $this->TextStyleArr=$TextStyleArr;
 
        if (!isset($this->TextStyleArr["text-align"]))          $this->TextStyleArr["text-align"] = DEFAULT_TEXT_ALLIGNMENT;
		if (!isset($this->TextStyleArr["Height"]))              $this->TextStyleArr["Height"] = $this->MessageStyleArr["Height"]*DEFAULT_TEXT_HEIGHT_RATIO;
		if (!isset($this->TextStyleArr["Width"]))               $this->TextStyleArr["Width"] =  $this->MessageStyleArr["Width"];
		if (!isset($this->TextStyleArr["color"]))               $this->TextStyleArr["color"] = DEFAULT_TEXT_COLOR; 
		if (!isset($this->TextStyleArr["background-color"]))    $this->TextStyleArr["background-color"]= DEFAULT_TEXT_BACKGROUND_COLOR; 
						

if ($ControlStyleArr!='') $this->ControlStyleArr=$ControlStyleArr;

        if (!isset($this->ControlStyleArr["text-align"]))       $this->ControlStyleArr["text-align"] = "right";
		if (!isset($this->ControlStyleArr["Height"]))           $this->ControlStyleArr["Height"] = $this->MessageStyleArr["Height"]*DEFAULT_CONTROL_HEIGHT_RATIO+$FF_FIX;
		if (!isset($this->ControlStyleArr["Width"]))            $this->ControlStyleArr["Width"] = $this->MessageStyleArr["Width"];
		if (!isset($this->ControlStyleArr["color"]))            $this->ControlStyleArr["color"] = DEFAULT_CONTROL_TEXT_COLOR; 
		if (!isset($this->ControlStyleArr["background-color"])) $this->ControlStyleArr["background-color"] = $this->TextStyleArr["background-color"]; 
					
		
		


$this->id = "div_".uniqid();  // assign a uniqe id to each message
$this->Text = $Msgtxt;
$this->HeadLineTxt = $HeadlineTxt;
$this->timeout = $timeout;
if ($controlTXT=='')
$this->ControlTxt = DEFAULT_CONTROL_TEXT_WORDING;
else
$this->ControlTxt = $controlTXT;

}

// Utility method to serialize associative array and accomulate a styling string 
// That would be assign for the Message element (MSG/Headling/Text/Control).


////////////////////////////////
	//
	//	PUBLIC METHODS
	//

		/**
		  *
		  * @shortdesc  serialize associative array and accomulate a styling string 
          * That would be assigned for the Message element (MSG/Headling/Text/Control).
		  * Parameters : 
		  * $styleArr : associative array of styling
		  * method : "curl" (in case enabled) or "fopen" (default)
		  * @public
		  * @return String in the form of "field1:value1;field2:value2;"...
		  *
		  **/
function parseStyleArray($styleArr){
$str="";
foreach ($styleArr as $key=>$value) 
 $str.=$key.":".$value.";";
return $str;
}

/**
		  *
		  * @shortdesc create HTML code out of the 
		  * Message configuration and styling parameters. 
		  * Parameters : 
		  * $styleArr : associative array of styling
		  * @public
		  * @return String;
		  *
		  **/
		  
		  
function populateHTML() { 


// parse styling variables

$msgStyleString = $this->parseStyleArray($this->MessageStyleArr);
$headlineStyleString = $this->parseStyleArray($this->HeadlineStyleArr);
$textStyleString = $this->parseStyleArray($this->TextStyleArr);
$controlStyleString =  $this->parseStyleArray($this->ControlStyleArr);

$this->HTML = 
'<div name="'.$this->id.'" id="'.$this->id.'"  style="'.$msgStyleString.'">
  <div style="'.$headlineStyleString.'">'.$this->HeadLineTxt.'</div>
  <div style="'.$textStyleString.'">'.$this->Text.'</div>
  <div style="'.$controlStyleString.'" onClick="document.all.'.$this->id.'.style.visibility=\'hidden\';return false;">'.$this->ControlTxt.'</div>
</div>
';

// apply Timeout variable 
if ($this->timeout!=0) 

$this->HTML .= 
'<script>
var str = "document.all.'.$this->id.'.style.visibility=\'hidden\';";
var tmp = window.setTimeout("eval(str);",'.$this->timeout.');
</script>';
}

// Print the HTML
function PrintMsg() {
echo $this->HTML;
}

} // class




