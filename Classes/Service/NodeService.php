<?php
namespace Carbon\ResourceProxy\Service;

use Neos\Flow\Annotations as Flow;
use Doctrine\Common\Collections\ArrayCollection;
use Neos\ContentRepository\Domain\Factory\NodeFactory;
use Neos\ContentRepository\Domain\Repository\NodeDataRepository;
use Neos\ContentRepository\Domain\Service\ContextFactoryInterface;
use Neos\ContentRepository\Domain\Service\NodeTypeManager;
use Neos\Flow\Persistence\Exception\IllegalObjectTypeException;
use Neos\Flow\Persistence\PersistenceManagerInterface;
use Neos\Media\Domain\Model\AssetCollection;
use Neos\Media\Domain\Model\Tag;
use Neos\Media\Domain\Repository\AssetCollectionRepository;
use Neos\Media\Domain\Repository\TagRepository;
use phpDocumentor\Reflection\Types\Boolean;

#[Flow\Scope('singleton')]
class NodeService
{
    const ASSET_COLLECTION_TITLE = 'ResourceProxy';

    #[Flow\Inject]
    protected NodeFactory $nodeFactory;

    #[Flow\Inject]
    protected ContextFactoryInterface $contextFactory;

    #[Flow\Inject]
    protected NodeTypeManager $nodeTypeManager;

    #[Flow\Inject]
    protected NodeDataRepository $nodeDataRepository;

    #[Flow\Inject]
    protected PersistenceManagerInterface $persistenceManager;

    #[Flow\Inject]
    protected AssetCollectionRepository $assetCollectionRepository;

    #[Flow\Inject]
    protected TagRepository $tagRepository;


    /**
     * @param string $title
     * @return AssetCollection
     * @throws IllegalObjectTypeException
     */
    public function findOrCreateAssetCollection(string $title = self::ASSET_COLLECTION_TITLE): AssetCollection
    {
        /** @var AssetCollection $asseteCollection */
        $asseteCollection = $this->assetCollectionRepository->findByTitle($title)->getFirst();

        if ($asseteCollection == null) {
            $asseteCollection = new AssetCollection($title);

            $this->assetCollectionRepository->add($asseteCollection);
            $this->persistenceManager->whitelistObject($asseteCollection);
        }

        return $asseteCollection;
    }

    /**
     * @param string $label
     * @return Tag
     * @throws IllegalObjectTypeException
     */
    public function findOrCreateAssetTag(string $label, ArrayCollection $assetCollections): Tag
    {
        /** @var Boolean $doCreateTag */
        $doCreateTag = false;

        /** @var Tag $tag */
        $tag = $this->tagRepository->findByLabel($label)->getFirst();

        if ($tag === null) { // check if tag exists
            return $this->createTag($label, $assetCollections);
        }

        /** @var AssetCollection $collection */
        foreach($tag->getAssetCollections() as $collection) { //check if tag has the accoring asset collection assigned
            if ($collection->getTitle() === self::ASSET_COLLECTION_TITLE) {
                return $tag;
            }
        }

        return $this->createTag($label, $assetCollections); // create tag anyway
    }

    /**
     * @param string $label
     * @param ArrayCollection $assetCollections
     * @return Tag
     * @throws IllegalObjectTypeException
     */
    private function createTag(string $label, ArrayCollection $assetCollections): Tag
    {
        $tag = new Tag($label);
        $tag->setAssetCollections($assetCollections);

        $this->tagRepository->add($tag);
        $this->persistenceManager->whitelistObject($tag);

        return $tag;
    }

}
