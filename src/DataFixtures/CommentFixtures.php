<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends AbstractFixtures implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {

// Tableau des titres
$titles = array(
    "Un combat épique !",
    "La stratégie paye !",
    "Un retournement de situation !",
    "Une bataille acharnée !",
    "La vitesse contre la force !",
    "Un combat de titans !",
    "Le combat de l'année !",
    "Une confrontation légendaire !",
    "L'affrontement ultime !",
    "Un duel palpitant !",
    "La bataille des champions !",
    "Le choc des titans !",
    "Une lutte sans merci !",
    "Le match de tous les dangers !",
    "La guerre des mondes !",
    "Le duel des héros !",
    "Un affrontement historique !",
    "La rivalité inébranlable !",
    "La rencontre tant attendue !",
    "Le duel des légendes !"
);

// Tableau des commentaires
$comments = array(
    "Deux combattants s'affrontent dans une arène bondée. Les enjeux sont élevés et le suspense est à son comble !",
    "L'un des combattants semble avoir trouvé une faille dans la stratégie de son adversaire. Que va-t-il se passer ensuite ?",
    "Un retournement de situation inattendu survient, changeant le cours du combat et surprenant tout le monde !",
    "Les deux adversaires se livrent à un affrontement intense, démontrant une détermination sans faille à remporter la victoire !",
    "La vitesse rencontre la force dans un duel épique où chaque mouvement compte. Qui sortira vainqueur de cette lutte ?",
    "Deux puissants combattants se font face, chacun déterminé à prouver sa supériorité sur l'autre dans ce combat titanesque !",
    "Les spectateurs sont témoins du combat le plus intense de l'année, où les combattants donnent tout ce qu'ils ont pour l'emporter !",
    "Une confrontation légendaire entre deux adversaires de renom, dont l'issue restera gravée dans les mémoires !",
    "C'est l'affrontement ultime entre deux rivaux ancestraux, où seul le plus fort sortira vainqueur !",
    "Les deux combattants s'engagent dans un duel palpitant où chaque mouvement est scruté avec attention par le public !",
    "Les champions se rencontrent dans l'arène, prêts à se battre jusqu'au bout pour le titre suprême !",
    "Un choc monumental entre deux géants, où la terre tremble sous la force de leurs coups !",
    "Une lutte sans merci où les combattants ne reculent devant rien pour prendre le dessus sur leur adversaire !",
    "Le danger est à son comble alors que les deux adversaires s'affrontent dans un combat où la moindre erreur peut être fatale !",
    "Une bataille épique qui transcende les frontières, attirant l'attention de tous les peuples de la galaxie !",
    "Les héros se retrouvent face à face dans un duel qui décidera du destin de l'univers tout entier !",
    "Un affrontement historique qui restera gravé dans les annales, marquant une nouvelle ère pour les combats !",
    "La rivalité entre deux adversaires indéfectibles atteint son paroxysme dans ce duel où aucun des deux ne veut céder !",
    "La rencontre tant attendue entre deux légendes vivantes qui se disputent la suprématie sur le champ de bataille !",
    "Les légendes se font face dans un duel qui déterminera une fois pour toutes qui est le plus grand guerrier de tous les temps !"
);


        for ($i = 0; $i < 30; $i++) {
            $comment = new Comment();

            $comment->setUser($this->getReference('user_' . $this->faker->numberBetween(0, 9)));
            $comment->setDuel($this->getReference('duel_' . $this->faker->numberBetween(0, 29)));
            $comment->setTitle($titles[$this->faker->numberBetween(0, 19)]);
            $comment->setComment($comments[$this->faker->numberBetween(0, 19)]);
            $comment->setCreated(new \DateTime());
            $comment->setEdited($this->faker->dateTimeBetween(new \DateTime(), '+3 week'));

            $manager->persist($comment);

            $this->setReference('comment_' . $i, $comment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            DuelFixtures::class,
        ];
    }
}
