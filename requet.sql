SELECT 
        o.id, o.profession_id, o.personne_membre_id, o.description, o.date_offre, o.titre,
        p.id AS personne_id, p.id_village_id, p.id_genre_id, p.nom_membre, p.date_de_naissance, 
        p.address, p.email, p.prenom_membre, p.date_inscription, p.fokotany, p.address_tana, 
        p.cin, p.arrondissement, pr.nom_profession,
        STRING_AGG(t.telephone, ', ') AS telephones
    FROM offre_emplois o
    LEFT JOIN personne_membre p ON p.id = o.personne_membre_id
    LEFT JOIN telephone t ON t.id_personne_membre_id = p.id
    LEFT JOIN profession pr ON pr.id = o.profession_id
    GROUP BY o.id, o.profession_id, o.personne_membre_id, o.description, o.date_offre, o.titre,
             p.id, p.id_village_id, p.id_genre_id, p.nom_membre, p.date_de_naissance, 
             p.address, p.email, p.prenom_membre, p.date_inscription, p.fokotany, p.address_tana, 
             p.cin, p.arrondissement, pr.nom_profession
    ORDER BY o.date_offre DESC;