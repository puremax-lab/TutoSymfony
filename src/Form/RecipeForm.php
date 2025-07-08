<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\AsciiSlugger;

class RecipeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Titre"])
            ->add('slug', HiddenType::class)
            ->add('content', TextareaType::class)
            // ->add('createdAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updatedAt', null, [
            //     'widget' => 'single_text',
            // ])
            ->add('duration')
            ->add("save", SubmitType::class, [
                'label' => "Envoyer"])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->autoSlug(...));
        ;
    }

    public function autoSlug(PreSubmitEvent $event): void
    {
        $data = $event ->getData();
        $slugger = new AsciiSlugger();
        if (empty($data['slug']) || $data['slug'] != strtolower($slugger->slug($data['title']))) {
            $data['slug'] = strtolower($slugger->slug($data['title']));
            $event->setData($data);
        }
    }
}
