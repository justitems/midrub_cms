<?php
/**
 * Rss Option Class
 *
 * This file loads the Clean Class with methods to read the xml content
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Define the page namespace
namespace CmsBase\Classes\Rss\Options;

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Define the namespaces to use
use CmsBase\Classes\Rss\Helpers as CmsBaseClassesRssHelpers;

/*
 * Rss class loads the methods to read the xml content
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Rss {

    /**
     * The public method the_xml_content processes the xml content
     * 
     * @param string $xml with content
     * 
     * @since 0.0.8.5
     * 
     * @return array with response
     */
    public function the_xml_content($xml) {
        
        // XML content
        $xml_content = array();

        // Turn the XML object to array
        $xml_array = json_decode(json_encode($xml), true);

        // Verify if channel exists
        if ( empty($xml_array['channel']) ) {
            return array(
                'success' => FALSE
            );
        }

        // Verify if title exists
        if ( isset($xml_array['channel']['title']) ) {

            // Make clean the title
            $title = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($xml_array['channel']['title']);

            // Verify if title exists
            if ( !empty($title) ) {

                // Add header
                $xml_content['header'] = array(
                    'title' => $title
                );

                // Verify if description exists
                if ( !empty($xml_array['channel']['description']) ) {

                    // Make clean the description
                    $description = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($xml_array['channel']['description']);

                    // Verify if description exists
                    if ( !empty($description) ) {
                    
                        // Add description
                        $xml_content['header']['description'] = $description;
                        
                    }

                }

                // Verify if pubDate exists
                if ( !empty($xml_array['channel']['pubDate']) ) {

                    // Make clean the pubDate
                    $pubDate = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($xml_array['channel']['pubDate']);

                    // Verify if pubDate exists
                    if ( !empty($pubDate) ) {
                    
                        // Add pubDate
                        $xml_content['header']['update'] = $pubDate;
                        
                    }

                }

                // Verify if image exists
                if ( !empty($xml_array['channel']['image']) ) {

                    // Verify if image is an array
                    if ( is_array($xml_array['channel']['image']) ) {

                        // Verify if link exists
                        if ( !empty($xml_array['channel']['image']['link']) ) {

                            // Make clean the image link
                            $image_link = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($xml_array['channel']['image']['link']);

                            // Verify if image link exists
                            if ( !empty($image_link) ) {
                            
                                // Verify if author exists
                                if ( !empty($xml_content['header']['author']) ) {

                                    // Add author url
                                    $xml_content['header']['author']['url'] = $image_link;

                                } else {

                                    // Add author url
                                    $xml_content['header']['author'] = array(
                                        'url' => $image_link
                                    );

                                }
                                
                            }

                            // Make clean the image url
                            $image_url = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($xml_array['channel']['image']['url']);

                            // Verify if image url exists
                            if ( !empty($image_url) ) {
                            
                                // Verify if author exists
                                if ( !empty($xml_content['header']['author']) ) {

                                    // Add author image url
                                    $xml_content['header']['author']['image_url'] = $image_url;

                                } else {

                                    // Add author image url
                                    $xml_content['header']['author'] = array(
                                        'image_url' => $image_url
                                    );

                                }
                                
                            }

                            // Make clean the image title
                            $image_title = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($xml_array['channel']['image']['title']);

                            // Verify if image title exists
                            if ( !empty($image_title) ) {
                            
                                // Verify if author exists
                                if ( !empty($xml_content['header']['author']) ) {

                                    // Add author name
                                    $xml_content['header']['author']['name'] = $image_title;

                                } else {

                                    // Add author name
                                    $xml_content['header']['author'] = array(
                                        'name' => $image_title
                                    );

                                }
                                
                            }

                        }

                    }

                }

            }

        }

        // Verify if items exists
        if ( !empty($xml_array['channel']['item']) ) {

            // Set items
            $xml_content['items'] = array();

            // List the items
            foreach ( $xml_array['channel']['item'] as $id => $entry ) {

                // Item container
                $item = array();

                // Verify if title exists
                if ( isset($entry['title']) ) {

                    // Prepare the title
                    $title = '';

                    // Verify if the title is an array
                    if ( is_array($entry['title']) ) {

                        // Turn array to string
                        $title = (string)$xml->channel->item[$id]->title;

                    } else {

                        // Set title
                        $title = $entry['title'];

                    }

                    // Make clean the title
                    $entry_title = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($title);

                    // Verify if the entry title exists
                    if ( !empty($entry_title) ) {

                        // Add title to the item
                        $item['title'] = $entry_title;

                    }

                }
                
                // Verify if description exists
                if ( isset($entry['description']) ) {

                    // Prepare the description
                    $description = '';

                    // Verify if the description is an array
                    if ( is_array($entry['description']) ) {

                        // Turn array to string
                        $description = (string)$xml->channel->item[$id]->description;

                    } else {

                        // Set description
                        $description = $entry['description'];

                    }

                    // Make clean the description
                    $entry_description = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($description);

                    // Verify if the entry description exists
                    if ( !empty($entry_description) ) {

                        // Add description to the item
                        $item['content'] = $entry_description;

                    }

                }

                // Verify if pubDate exists
                if ( !empty($entry['pubDate']) ) {

                    // Make clean the pubDate
                    $entry_pubDate = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($entry['pubDate']);

                    // Verify if the entry pubDate exists
                    if ( !empty($entry_pubDate) ) {

                        // Add pubDate to the item
                        $item['update'] = $entry_pubDate;

                    }

                }

                // Verify if image exists
                if ( !empty($entry['image']) ) {

                    // Verify if image url exists
                    if ( !empty($entry['image']['url']) ) {

                        // Make clean the item image url
                        $item_image_url = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($entry['image']['url']);

                        // Verify if item imageurl exists
                        if ( !empty($item_image_url) ) {

                            // Set the image url
                            $item['image_url'] = $item_image_url;                           
                            
                        }

                    }

                }

                // Verify if the item still has no an image
                if ( empty($item['image_url']) ) {

                    // Get the itunes key
                    $itunes = $xml->channel->item[$id]->children('itunes', TRUE);

                    // Verify if itunes exists
                    if ( isset($itunes->image) ) {
 
                        // Verify if itunes image exists
                        if ( !empty($itunes->image->attributes()) ) {
                            
                            // Get the itunes image
                            $itunes_image = $itunes->image->attributes();
  
                            // Verify if itunes image exists
                            if ( !empty($itunes_image) ) {
    
                                // Turn object to array
                                $itunes_image_array = (array)$itunes_image;
    
                                // Verify if @attributes exists
                                if ( !empty($itunes_image_array['@attributes']) ) {
    
                                    // Verify if href exists
                                    if ( !empty($itunes_image_array['@attributes']['href']) ) {
    
                                        // Make clean the url
                                        $media_image_url = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($itunes_image_array['@attributes']['href']);
    
                                        // Verify if image url exists
                                        if ( !empty($media_image_url) ) {
                                        
                                            // Add image url
                                            $item['image_url'] = $media_image_url;
                                            
                                        }
    
                                    }
    
                                }
    
                            }                            
                            
                        }

                    }

                }

                // Verify if the item still has no an image
                if ( empty($item['image_url']) ) {

                    // Get the media key
                    $media = $xml->channel->item[$id]->children('media', TRUE);

                    // Verify if media exists
                    if ( isset($media->thumbnail) ) {
                        
                        // Verify if media thumbnail exists
                        if ( !empty($media->thumbnail->attributes()) ) {

                            // Get the media thumbnail
                            $media_thumbnail = $media->thumbnail->attributes();
    
                            // Verify if media thumbnail exists
                            if ( !empty($media_thumbnail) ) {
    
                                // Turn object to array
                                $media_thumbnail_array = (array)$media_thumbnail;
    
                                // Verify if @attributes exists
                                if ( !empty($media_thumbnail_array['@attributes']) ) {
    
                                    // Verify if url exists
                                    if ( !empty($media_thumbnail_array['@attributes']['url']) ) {
    
                                        // Make clean the url
                                        $media_thumbnail_url = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($media_thumbnail_array['@attributes']['url']);
    
                                        // Verify if thumbnail url exists
                                        if ( !empty($media_thumbnail_url) ) {
                                        
                                            // Add image url
                                            $item['image_url'] = $media_thumbnail_url;
                                            
                                        }
    
                                    }
    
                                }
    
                            } else {
                                
                                // Verify if media group exists
                                if ( !empty($media->group) ) {
    
                                    // Verify if media group content exists
                                    if ( !empty($media->group->content->attributes()) ) {
    
                                        // Turn object to array
                                        $group_media_array = (array)$media->group->content->attributes();  
                                        
                                        // Verify if @attributes exists
                                        if ( !empty($group_media_array['@attributes']) ) {
    
                                            // Verify if url exists
                                            if ( !empty($group_media_array['@attributes']['url']) ) {
    
                                                // Make clean the url
                                                $media_image_url = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($group_media_array['@attributes']['url']);
    
                                                // Verify if image url exists
                                                if ( !empty($media_image_url) ) {
                                                
                                                    // Add image url
                                                    $item['image_url'] = $media_image_url;
                                                    
                                                }
    
                                            }
    
                                        }
    
                                    }
    
                                } else if ( !empty($media->content->attributes()) ) {
    
                                    // Turn object to array
                                    $content_media_array = (array)$media->content->attributes();
                                    
                                    // Verify if @attributes exists
                                    if ( !empty($content_media_array['@attributes']) ) {
    
                                        // Verify if url exists
                                        if ( !empty($content_media_array['@attributes']['url']) ) {
    
                                            // Make clean the url
                                            $media_image_url = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($content_media_array['@attributes']['url']);
    
                                            // Verify if image url exists
                                            if ( !empty($media_image_url) ) {
                                            
                                                // Add image url
                                                $item['image_url'] = $media_image_url;
                                                
                                            }
    
                                        }
    
                                    }
    
                                }
    
                            }
                            
                        }

                    }

                }

                // Verify if the item still has no an image
                if ( empty($item['image_url']) ) {

                    // Get the media_enclosure key
                    $media_enclosure = $xml->channel->item[$id]->enclosure;

                    // Verify if media_enclosure exists
                    if ( !empty($media_enclosure->attributes()) ) {

                        // Turn object to array
                        $media_enclosure_array = (array)$xml->channel->item[$id]->enclosure->attributes();
                      
                        // Verify if @attributes exists
                        if ( !empty($media_enclosure_array['@attributes']) ) {

                            // Verify if url exists
                            if ( !empty($media_enclosure_array['@attributes']['url']) && !empty($media_enclosure_array['@attributes']['type']) ) {

                                // Verify if type is image
                                if ( substr($media_enclosure_array['@attributes']['type'], 0, 5) === 'image' ) {

                                    // Make clean the url
                                    $media_image_url = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($media_enclosure_array['@attributes']['url']);

                                    // Verify if image url exists
                                    if ( !empty($media_image_url) ) {
                                    
                                        // Add image url
                                        $item['image_url'] = $media_image_url;
                                        
                                    }

                                }

                            }

                        }  

                    }

                }

                // Verify if link exists
                if ( isset($entry['link']) ) {

                    // Prepare the link
                    $link = '';

                    // Verify if the link is an array
                    if ( is_array($entry['link']) ) {

                        // Turn array to string
                        $link = (string)$xml->channel->item[$id]->link;

                    } else {

                        // Set link
                        $link = $entry['link'];

                    }

                    // Make clean the item url
                    $item_url = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($link);

                    // Verify if item url exists
                    if ( !empty($item_url) ) {
                    
                        // Verify if item link exists
                        if ( empty($item['link']) ) {
                            $item['link'] = $item_url;
                        }                            
                        
                    }

                }

                // Verify if link missing
                if ( empty($item['link']) ) {

                    // Make clean the item url
                    $item_url = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($entry['guid']);

                    // Verify if item url exists
                    if ( !empty($item_url) ) {
                    
                        // Verify if item link exists
                        if ( empty($item['link']) ) {
                            $item['link'] = $item_url;
                        }                            
                        
                    }

                }

                // Verify if author exists
                if ( !empty($entry['author']) ) {

                    // Make clean the item author
                    $author = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($entry['author']);

                    // Verify if item author exists
                    if ( !empty($author) ) {

                        // Add author name
                        $item['author'] = array(
                            'name' => $author
                        );                       
                        
                    }

                }

                // Verify if the item is not empty
                if ( !empty($item) ) {

                    // Add item to the container
                    $xml_content['items'][] = $item;

                }

            }

        }

        // Verify if items exists
        if ( !empty($xml_content['items']) ) {

            return array(
                'success' => TRUE,
                'content' => $xml_content
            );

        } else {

            return array(
                'success' => FALSE
            );

        }
        
    }

}