<?php

namespace app\Security\Voter;

use App\Entity\Products;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductsVoter extends Voter
{
    const EDIT = 'PRODUCT_EDIT';
    const DELETE = 'PRODUCT_DELETE';

    private $security;
    //le constructeur doit rester public
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $product): bool
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }
        if (!$product instanceof Products) {
            return false;
        }
        return true;
        //deuxieme methode pour simplifier la condition en rassemblant les deux lignes:

        //return in_array($attribute, [self::EDIT, self::DELETE]) && 
        //$product instanceof Products;
    }

    protected function voteOnAttribute($attribute, $product, TokenInterface $token): bool
    {
        // on récupére l'utilisateur à partir du token
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        // on verifie si l'utilisateur est admin
        if ($this->security->isGranted('ROLE_ADMIN'))
            return true;

        //on va vérifier les permissions

        switch ($attribute) {
            case self::EDIT:
                // on verifie si l'utilisateur peut editer
                return $this->canEdit();
                break;
            case self::DELETE;
                //on verifie si l'utilisateur peut supprimer
                return $this->canDelete();
                break;
        }
    }

    private function canEdit()
    {
        return $this->security->isGranted('ROLE_PRDUCT_ADMIN');
    }
    private function canDelete()
    {
        return $this->security->isGranted('ROLE_PRDUCT_ADMIN');
    }
}
