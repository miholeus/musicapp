<?php
/**
 * This file is part of ApiBundle\Form package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApiBundle\Form;

use CoreBundle\Entity\User;
use CoreBundle\Entity\Vote;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class VoteType extends AbstractType
{
    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', EntityType::class, [
            'class' => 'CoreBundle\Entity\Instrument',
            'choice_label' => 'name',
            'property_path' => 'instrument'
        ]);

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $e) {
            /** @var Vote $data */
            $data = $e->getData();
            $data->setUser($this->getUser());
        });
    }

    public function getUser(): User
    {
        if (null === $this->tokenStorage->getToken()) {
            throw new \InvalidArgumentException("User must be logged in");
        }
        return $this->tokenStorage->getToken()->getUser();
    }    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Vote'
        ));
    }
}