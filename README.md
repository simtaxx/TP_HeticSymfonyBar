# TP_HeticSymfonyBar


## Part - 4

  **Voici un code Doctrine à écrire dans le Repository CategoryRepository, qu'en pensez vous ? Décrivez son utilité dans l'application si on devait le mettre en place.**

  ```
  public function findCatSpecial(int $id)
    {
        return $this->createQueryBuilder('c')
            ->join('c.beers', 'b') // raisonner en terme de relation
            ->where('b.id = :id')
            ->setParameter('id', $id)
            ->andWhere('c.term = :term')
            ->setParameter('term', 'special')
            ->getQuery()
            ->getResult();
    }
  ```

  findCatSpecial() exécute une requête qui va faire une jointure entre la table category et beer via l'ORM
  et va retourner les catégories spéciales d'une bière.


## Contributors

  - Donaël Walter
  - Haris Souici
  - Loïc TORRES
  - Najib Tahar-Berrabah
  - Tom Despres
