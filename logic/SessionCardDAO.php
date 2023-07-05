<?php
include_once "User.php";
include_once "Card.php";
include_once "CardDAO.php";

class SessionCardDAO implements CardDAO
{

    public function saveCard($card)
    {
        $card->expirationDate = date_format(date_create($card->expirationDate), "d.m.y");
        $_SESSION['cards'][$card->id] = serialize($card);
        return $card->id;
    }

    public function updateCard($card)
    {
        $_SESSION['cards'][$card->id] = serialize($card);
    }

    public function claimCard()
    {
        $card = $this->loadCard($_GET['id']);
        if (isset($_SESSION['loggedInUser'])) {
            if ($card->claimer == null) {
                $_SESSION['claimedCards'][$_SESSION['loggedInUser']][$_GET['id']] = serialize($card);
                $card->claimer = unserialize($_SESSION['loggedInUser'])->email;
                $this->updateCard($_GET['id'], $card);
            }
        }
    }

    public function unclaimCard()
    {
        $card = $this->loadCard($_GET['id']);
        if (isset($_SESSION['loggedInUser'])) {
            if (isset($_SESSION['claimedCards'][$_SESSION['loggedInUser']][$_GET['id']])) {
                unset($_SESSION['claimedCards'][$_SESSION['loggedInUser']][$_GET['id']]);
                $card->claimer = null;
                $this->updateCard($_GET['id'], $card);
            }
        }
    }

    public function loadCard($id)
    {
        if (isset($_SESSION['cards'])) {
            foreach ($_SESSION['cards'] as $card) {
                if (unserialize($card)->id == $id) {
                    return unserialize($card);
                }
            }
        }
        return new Card;
    }

    public function loadUserClaimedCards(): array
    {
        $user = $_SESSION['loggedInUser'];
        $claimedCards = array();
        if (isset($_SESSION['claimedCards'][$user])) {
            foreach ($_SESSION['claimedCards'][$user] as $card) {
                $claimedCards[] = $card;
            }
        }
        return $claimedCards;
    }

    public function loadUserCards(): array
    {
        $user = unserialize($_SESSION['loggedInUser']);
        $cards = array();
        if (isset($_SESSION['cards'])) {
            foreach ($_SESSION['cards'] as $card) {
                if (unserialize($card)->owner == $user->email) {
                    $cards[] = $card;
                }
            }
        }
        return $cards;
    }

    public function loadAllCards(): array
    {
        $cards = array();
        if (isset($_SESSION['cards'])) {
            foreach ($_SESSION['cards'] as $card) {
                $cards[] = $card;
            }
        }
        return $cards;
    }

    public function loadAllUnclaimedCards(): array
    {
        $cards = array();
        if (isset($_SESSION['cards'])) {
            foreach ($_SESSION['cards'] as $card) {
                if (unserialize($card)->claimer == null) {
                    $cards[] = $card;
                }
            }
        }
        return $cards;
    }
}
?>