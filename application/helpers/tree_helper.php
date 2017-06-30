<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('make_array_for_tree')) {
    function make_array_for_tree($result)
    {
        foreach ($result as $members) {
            // $member_id =$members['id'];
            $menu[$members['id']] = array(
                'text' => $members['first_name'],
                'parentID' => $members['parent_id'],
                'id' => $members['id']
            );
        }
        $addedAsChildren = array();
        foreach ($menu as $id => &$menuItem) { // note that we use a reference so we don't duplicate the array
            if (!empty($menuItem['parentID'])) {
                $addedAsChildren[] = $id; // it should be removed from root, but we'll do that later
                if (!isset($menu[$menuItem['parentID']]['children'])) {
                    $menu[$menuItem['parentID']]['children'] = array(
                        $id => &$menuItem
                    ); // & means we use the REFERENCE
                } else {
                    $menu[$menuItem['parentID']]['children'][$id] =& $menuItem; // & means we use the REFERENCE
                }
            }
            unset($menuItem['parentID']); // we don't need parentID any more
        }
        unset($menuItem); // unset the reference

        foreach ($addedAsChildren as $itemID) {
            unset($menu[$itemID]); // remove it from root so it's only in the ['children'] subarray
        }
        return $menu;
    }
}

function makeTree($menu = array('text' => '', 'parent_id' => '', 'id' => ''))
{
    $i = 0;
    $tree = '<ul>';
    foreach ($menu as $id => $menuItem) {
        $member_id = $menuItem['id'];
        $tree .= '<li><a href="' . base_url('dashboard/tree/' . $member_id) . '">' . $menuItem['text'] . '</a>';
        if (!empty($menuItem['children'])) {
            $tree .= makeTree($menuItem['children']);
            if ($i == 10) {
                break;
            }
            $i++;
        }
        $tree .= '</li>';
    }
    return $tree . '</ul>';
}

FUNCTION simple_encrypt($Str_Message)
{
    $Str_Message = str_replace('@', 490, $Str_Message);
    $Str_Message = str_replace('.', 855, $Str_Message);
    $Str_Message = strtolower($Str_Message);
    $Str_Message = str_rot13($Str_Message);
    return $Str_Message;
}

FUNCTION simple_decrypt($Str_Message)
{
    $Str_Message = str_replace(490, '@', $Str_Message);
    $Str_Message = str_replace(855, '.', $Str_Message);
    $Str_Message = strtolower($Str_Message);
    $Str_Message = str_rot13($Str_Message);
    return $Str_Message;
}

function customDie($location)
{
    redirect(base_url($location));
    exit();
}

function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale)
{
    list($imagewidth, $imageheight, $imageType) = getimagesize($image);
    $imageType = image_type_to_mime_type($imageType);
    $newImageWidth = ceil($width * $scale);
    $newImageHeight = ceil($height * $scale);
    $newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
    if(!$newImage){
        return null;
    }
    switch ($imageType) {
        case "image/gif":
            $source = imagecreatefromgif($image);
            break;
        case "image/pjpeg":
        case "image/jpeg":
        case "image/jpg":
            $source = imagecreatefromjpeg($image);
            break;
        case "image/png":
        case "image/x-png":
            $source = imagecreatefrompng($image);
            break;
        default :
            return null;
    }
    if(!imagecopyresampled($newImage, $source, 0, 0, $start_width, $start_height, $newImageWidth, $newImageHeight, $width, $height)){
        return null;
    }
    switch ($imageType) {
        case "image/gif":
            imagegif($newImage, $thumb_image_name);
            break;
        case "image/pjpeg":
        case "image/jpeg":
        case "image/jpg":
            imagejpeg($newImage, $thumb_image_name, 100);
            break;
        case "image/png":
        case "image/x-png":
            imagepng($newImage, $thumb_image_name);
            break;
    }
    chmod($thumb_image_name, 0777);

    return basename($thumb_image_name);
}