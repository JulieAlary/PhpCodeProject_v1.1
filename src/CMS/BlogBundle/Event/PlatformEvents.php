<?php

namespace CMS\BlogBundle\Event;

/**
 * Cette classe sert juste à faire la correspondance entre BlogEvents::POST_MESSAGE qui sera utilisée pour déclencher
 * l'événement
 *
 * Class BlogEvent
 * @package CMS\BlogBundle\Event
 */
final class BlogEvent
{

    const POST_MESSAGE = 'cms_blog.post_message';
}