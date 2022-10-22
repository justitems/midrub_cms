<?php
/**
 * Rss Atom Option Class
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
 * Atom class loads the methods to read the xml content
 * 
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */
class Atom {

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

        // Verify if entry exists
        if ( empty($xml_array['entry']) ) {
            return array(
                'success' => FALSE
            );
        }

        // Verify if title exists
        if ( isset($xml_array['title']) ) {

            // Make clean the title
            $title = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($xml_array['title']);

            // Verify if title exists
            if ( !empty($title) ) {

                // Add header
                $xml_content['header'] = array(
                    'title' => $title
                );

                // Verify if subtitle exists
                if ( !empty($xml_array['subtitle']) ) {

                    // Make clean the subtitle
                    $subtitle = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($xml_array['subtitle']);

                    // Verify if subtitle exists
                    if ( !empty($subtitle) ) {
                    
                        // Add subtitle
                        $xml_content['header']['description'] = $subtitle;
                        
                    }

                }

                // Verify if updated exists
                if ( !empty($xml_array['updated']) ) {

                    // Make clean the updated
                    $updated = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($xml_array['updated']);

                    // Verify if updated exists
                    if ( !empty($updated) ) {
                    
                        // Add updated
                        $xml_content['header']['updated'] = $updated;
                        
                    }

                } 
                
                // Verify if author exists
                if ( !empty($xml_array['author']) ) {

                    // Verify if name exists
                    if ( !empty($xml_array['author']['name']) ) {

                        // Make clean the author name
                        $author_name = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($xml_array['author']['name']);

                        // Verify if author name exists
                        if ( !empty($author_name) ) {
                        
                            // Add author name
                            $xml_content['header']['author'] = array(
                                'name' => $author_name
                            );
                            
                        }

                        // Verify if uri exists
                        if ( !empty($xml_array['author']['uri']) ) {

                            // Make clean the author uri
                            $author_uri = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($xml_array['author']['uri']);

                            // Verify if author uri exists
                            if ( !empty($author_uri) ) {
                            
                                // Add author url
                                $xml_content['header']['author']['url'] = $author_uri;
                                
                            }

                        }

                        // Verify if email exists
                        if ( !empty($xml_array['author']['email']) ) {

                            // Make clean the author email
                            $author_email = (new CmsBaseClassesRssHelpers\Clean())->the_clean_email($xml_array['author']['email']);

                            // Verify if author email exists
                            if ( !empty($author_email ) ) {
                            
                                // Add author email
                                $xml_content['header']['author']['email'] = $author_email;
                                
                            }

                        }
                        
                        // Get the GD parameter
                        $author_gd = $xml->author->children('gd', TRUE);

                        // Verify if the GD parameter exists
                        if ( !empty($author_gd) ) {

                            // Get the attributes
                            $author_gd_attributes = $author_gd->attributes();

                            // Verify if attributes exists
                            if ( $author_gd_attributes ) {

                                // Turn to array
                                $author_gd_attributes_array = (array)$author_gd_attributes;

                                // Verify if @attributes exists
                                if ( !empty($author_gd_attributes_array['@attributes']) ) {

                                    // Verify if src exists
                                    if ( !empty($author_gd_attributes_array['@attributes']['src']) ) {

                                        // Make clean the url
                                        $author_image_url = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($author_gd_attributes_array['@attributes']['src']);

                                        // Verify if image url exists
                                        if ( !empty($author_image_url) ) {
                                        
                                            // Add image url
                                            $xml_content['header']['author']['image_url'] = $author_image_url;
                                            
                                        }

                                    }

                                }

                            }

                        }

                    }

                } 

            }

        }

        // Set items
        $xml_content['items'] = array();

        // List the items
        foreach ( $xml_array['entry'] as $id => $entry ) {

            // Item container
            $item = array();

            // Verify if title exists
            if ( isset($entry['title']) ) {

                // Prepare the title
                $title = '';

                // Verify if the title is an array
                if ( is_array($entry['title']) ) {

                    // Turn array to string
                    $title = (string)$xml->entry[$id]->title;

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

            // Verify if published exists
            if ( !empty($entry['published']) ) {

                // Make clean the published
                $entry_published = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($entry['published']);

                // Verify if the entry published exists
                if ( !empty($entry_published) ) {

                    // Add published to the item
                    $item['published'] = $entry_published;

                }

            }

            // Verify if updated exists
            if ( !empty($entry['updated']) ) {

                // Make clean the updated
                $entry_updated = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($entry['updated']);

                // Verify if the entry updated exists
                if ( !empty($entry_updated) ) {

                    // Add updated to the item
                    $item['updated'] = $entry_updated;

                }

            }

            // Verify if content exists
            if ( !empty($entry['content']) ) {

                // Prepare the content
                $content = '';

                // Verify if the content is an array
                if ( is_array($entry['content']) ) {

                    // Turn array to string
                    $content = (string)$xml->entry[$id]->content;

                } else {

                    // Set content
                    $content = $entry['content'];

                }

                // Make clean the content
                $entry_content = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($content);

                // Verify if the entry content exists
                if ( !empty($entry_content) ) {

                    // Add content to the item
                    $item['content'] = $entry_content;

                }

            }

            // Verify if the content still missing
            if ( empty($item['content']) ) {

                // Verify if summary exists
                if ( isset($entry['summary']) ) {

                    // Prepare the summary
                    $summary = '';

                    // Verify if the summary is an array
                    if ( is_array($entry['summary']) ) {

                        // Turn array to string
                        $summary = (string)$xml->entry[$id]->summary;

                    } else {

                        // Set summary
                        $summary = $entry['summary'];

                    }

                    // Make clean the summary
                    $entry_summary = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($summary);

                    // Verify if the entry summary exists
                    if ( !empty($entry_summary) ) {

                        // Add summary to the item
                        $item['summary'] = $entry_summary;

                    }

                }

            }

            // Verify if link exists
            if ( !empty($entry['link']) ) {

                // Verify if the link is an array
                if ( is_array($entry['link']) ) {

                    // List the link variants
                    foreach ( $entry['link'] as $variant ) {

                        // Verify if @attributes exists
                        if ( empty($variant['@attributes']) ) {
                            continue;
                        }

                        // Verify if rel and href exists
                        if ( empty($variant['@attributes']['rel']) || empty($variant['@attributes']['type']) || empty($variant['@attributes']['href']) ) {
                            continue;
                        } 
                        
                        // Verify if type is text/html
                        if ( $variant['@attributes']['type'] !== 'text/html' ) {
                            continue;
                        }

                        // Make clean the item url
                        $item_url = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($variant['@attributes']['href']);

                        // Verify if item url exists
                        if ( !empty($item_url) ) {
                        
                            // Verify if item link exists
                            if ( empty($item['link']) ) {
                                $item['link'] = $item_url;
                                break;
                            }                            
                            
                        }

                    }

                }

            }

            // Verify if author exists
            if ( !empty($entry['author']) ) {

                // Verify if name exists
                if ( !empty($entry['author']['name']) ) {

                    // Make clean the author name
                    $author_name = (new CmsBaseClassesRssHelpers\Clean())->the_clean_text($entry['author']['name']);

                    // Verify if author name exists
                    if ( !empty($author_name) ) {
                    
                        // Add author name
                        $item['author'] = array(
                            'name' => $author_name
                        );
                        
                    }

                    // Verify if uri exists
                    if ( !empty($entry['author']['uri']) ) {

                        // Make clean the author uri
                        $author_uri = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($entry['author']['uri']);

                        // Verify if author uri exists
                        if ( !empty($author_uri) ) {
                        
                            // Add author uri
                            $item['author']['url'] = $author_uri;
                            
                        }

                    }

                    // Verify if email exists
                    if ( !empty($entry['author']['email']) ) {

                        // Make clean the author email
                        $author_email = (new CmsBaseClassesRssHelpers\Clean())->the_clean_email($entry['author']['email']);

                        // Verify if author email exists
                        if ( !empty($author_email ) ) {
                        
                            // Add author email
                            $item['author']['email'] = $author_email;
                            
                        }

                    }
                    
                    // Get the GD parameter
                    $author_gd = $xml->entry[$id]->author->children('gd', TRUE);

                    // Verify if the GD parameter exists
                    if ( !empty($author_gd) ) {

                        // Get the attributes
                        $author_gd_attributes = $author_gd->attributes();

                        // Verify if attributes exists
                        if ( !empty($author_gd_attributes) ) {

                            // Turn to array
                            $author_gd_attributes_array = (array)$author_gd_attributes;

                            // Verify if @attributes exists
                            if ( !empty($author_gd_attributes_array['@attributes']) ) {

                                // Verify if src exists
                                if ( !empty($author_gd_attributes_array['@attributes']['src']) ) {

                                    // Make clean the url
                                    $author_image_url = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($author_gd_attributes_array['@attributes']['src']);

                                    // Verify if image url exists
                                    if ( !empty($author_image_url) ) {
                                    
                                        // Add image url
                                        $item['author']['image_url'] = $author_image_url;
                                        
                                    }

                                }

                            }

                        }

                    }

                    // Get the media
                    $media = $xml->entry[$id]->children('media', TRUE);

                    // Verify if media exists
                    if ( !empty($media) ) {

                        // Get the media attributes
                        $media_attributes = $media->attributes();

                        // Verify if attributes exists
                        if ( !empty($media_attributes) ) {

                            // Turn to array
                            $media_attributes_array = (array)$media_attributes;

                            // Verify if @attributes exists
                            if ( !empty($media_attributes_array['@attributes']) ) {

                                // Verify if url exists
                                if ( !empty($media_attributes_array['@attributes']['url']) ) {

                                    // Make clean the url
                                    $media_image_url = (new CmsBaseClassesRssHelpers\Clean())->the_clean_url($media_attributes_array['@attributes']['url']);

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

            // Verify if the item is not empty
            if ( !empty($item) ) {

                // Add item to the container
                $xml_content['items'][] = $item;

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