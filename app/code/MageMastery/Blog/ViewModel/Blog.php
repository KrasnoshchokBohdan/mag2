<?php
declare(strict_types=1);
namespace MageMastery\Blog\ViewModel;

use MageMastery\Blog\Service\PostRepository;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\Data\PageSearchResultsInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Blog
 */
class Blog implements ArgumentInterface
{

    /**
     * @var SerializerInterface s
     */
    private $serializer;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @param SerializerInterface $serializer
     * @param PostRepository $postRepository
     * @param UrlInterface $url
     */
    public function __construct(
        SerializerInterface $serializer,
        PostRepository $postRepository,
        UrlInterface $url
    )
    {
        $this->serializer = $serializer;
        $this->postRepository = $postRepository;
        $this->url = $url;
    }


    /**
     * @return string
     */
    public function getPostsJson(): string
    {
       $postsSearchResults =  $this->postRepository->get();


        return $this->serializer->serialize($this->getPosts($postsSearchResults));
//        return $this->serializer->serialize($result);
    }

    /**
     * @param PageSearchResultsInterface $postsSearchResults
     * @return array
     */
    private function getPosts( PageSearchResultsInterface $postsSearchResults)
    {

        $result = [];

        /** @var PageInterface $post */
        foreach ($postsSearchResults->getItems() as $post){
            $result[] = [
                "id" => $post->getId(),
                "title" => $post->getTitle(),
                "url" => $this->url->getUrl($post->getIdentifier()),
                "published_data" => $post->getCreationTime(),
                "content" => $this->truncate(strip_tags($post->getContent()), 100),
                "author" => "Author1"
            ];
        }
        return $result;
    }

    /**
     * @param $phrase
     * @param $max_words
     * @return string
     */
    private function truncate($phrase, $max_words): string
    {
        $phrase_array = explode(' ',$phrase);
        if (count($phrase_array) > $max_words && $max_words > 0){
            $phrase = implode(' ', array_splice($phrase_array, 0, $max_words)).'...';
            return $phrase;
        }else{
            return $phrase;
        }
    }
}
