----------------- BDD - Illustrative examples   -----------------
----------- version 31 mars 2013, mise à jour le 09 février 2015 ----------------

-----------------------------------------------------------------------------
-- Clear previous information.
-----------------------------------------------------------------------------
DROP TABLE IF EXISTS Produit CASCADE;
DROP TABLE IF EXISTS Jeu CASCADE;
DROP TABLE IF EXISTS Genre CASCADE;
DROP TABLE IF EXISTS Editeur CASCADE;
DROP TABLE IF EXISTS Plateforme CASCADE;
DROP TABLE IF EXISTS Pegi CASCADE;
DROP TABLE IF EXISTS Utilisateur CASCADE;
DROP TABLE IF EXISTS Stock CASCADE;
DROP TABLE IF EXISTS Genre_Jeu CASCADE;
DROP TABLE IF EXISTS Pegi_Jeu CASCADE;
DROP TABLE IF EXISTS Reservation CASCADE;


-----------------------------------------------------------------------------
-- Initialize the structure.
-----------------------------------------------------------------------------
CREATE OR REPLACE PROCEDURAL LANGUAGE plpgsql;


CREATE TABLE Produit(
    id SERIAL,
    nom VARCHAR(50) NOT NULL,
    description TEXT,
    PRIMARY KEY(id)
);

CREATE TABLE Editeur(
    id SERIAL, 
    nom VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE Jeu(
    id SERIAL REFERENCES Produit(id),
    date_sortie TIMESTAMP,
    id_editeur SERIAL REFERENCES Editeur(id),
    PRIMARY KEY(id)
);

CREATE TABLE Genre(
    id SERIAL,
    nom VARCHAR(50) NOT NULL, 
    PRIMARY KEY(id)
);

CREATE TABLE Plateforme(
    id SERIAL,
    nom VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE Pegi(
    id SERIAL,
    nom VARCHAR(50) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE Utilisateur(
    login VARCHAR(100) NOT NULL,
    mdp VARCHAR(250) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    adresse VARCHAR(100) NOT NULL,
    telephone INTEGER NOT NULL,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    role VARCHAR(50) NOT NULL,
    CONSTRAINT login_chk CHECK (((login)::text ~* '^[0-9a-zA-Z._-]+@[0-9a-zA-Z._-]{2,}[.][a-zA-Z]{2,4}$'::text)),
    PRIMARY KEY (login)
);

CREATE TABLE Reservation(
    id SERIAL,
    date_reservation TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    etat VARCHAR(50) NOT NULL,
    login_utilisateur VARCHAR(100) REFERENCES Utilisateur(login),
    id_produit SERIAL REFERENCES Produit(id),
    PRIMARY KEY (id)
);

CREATE TABLE Stock(
    id_jeu SERIAL REFERENCES Jeu(id),
    id_plateforme SERIAL REFERENCES Plateforme(id),
    prix numeric NOT NULL CHECK (prix > 0),
    quantite INTEGER NOT NULL CHECK (quantite >= 0),
    PRIMARY KEY (id_jeu, id_plateforme)
);

CREATE TABLE Genre_Jeu(
    id_genre SERIAL REFERENCES Genre(id),
    id_jeu SERIAL REFERENCES Jeu(id),
    PRIMARY KEY (id_genre, id_jeu)
);

CREATE TABLE Pegi_Jeu(
    id_pegi SERIAL REFERENCES Pegi(id),
    id_jeu SERIAL REFERENCES Jeu(id),
    PRIMARY KEY(id_pegi, id_jeu)
);

CREATE VIEW JEU_DETAILS AS
    SELECT
        produit.id AS id_jeu,
        produit.nom AS nom,
        produit.description AS description,
        jeu.date_sortie AS date_sortie,
        genre_jeu.id_genre AS id_genre,
        stock.id_plateforme AS id_plateforme,
        stock.prix AS prix,
        stock.quantite AS quantite,
        pegi_jeu.id_pegi AS id_pegi,
        editeur.id AS id_editeur,
        editeur.nom AS nom_editeur
    FROM jeu
        JOIN produit ON jeu.id = produit.id
        JOIN genre_jeu ON jeu.id = genre_jeu.id_jeu
        JOIN stock ON jeu.id = stock.id_jeu
        JOIN pegi_jeu ON jeu.id = pegi_jeu.id_jeu
        JOIN editeur ON jeu.id_editeur = editeur.id;


-----------------------------------------------------------------------------
-- Insert some data.
-----------------------------------------------------------------------------

INSERT INTO Utilisateur VALUES ('test@test.com', 'test', 'test', 'test', 'test', '0000', CURRENT_TIMESTAMP, 'test');

INSERT INTO Pegi VALUES (1, '3');
INSERT INTO Pegi VALUES (2, '7');
INSERT INTO Pegi VALUES (3, '12');
INSERT INTO Pegi VALUES (4, '16');
INSERT INTO Pegi VALUES (5, '18');
INSERT INTO Pegi VALUES (6, 'Violence');
INSERT INTO Pegi VALUES (7, 'Langage grossier');
INSERT INTO Pegi VALUES (8, 'Peur');
INSERT INTO Pegi VALUES (9, 'Jeux de hasard');
INSERT INTO Pegi VALUES (10, 'Sexe');
INSERT INTO Pegi VALUES (11, 'Drogue');
INSERT INTO Pegi VALUES (12, 'Discrimination');

INSERT INTO Genre VALUES (1, 'Aventure');
INSERT INTO Genre VALUES (2, 'Course');
INSERT INTO Genre VALUES (3, 'FPS');
INSERT INTO Genre VALUES (4, 'Gestion / Wargames');
INSERT INTO Genre VALUES (5, 'MMORPG');
INSERT INTO Genre VALUES (6, 'Nouveaux genres');
INSERT INTO Genre VALUES (7, 'Plate-forme');
INSERT INTO Genre VALUES (8, 'RPG');
INSERT INTO Genre VALUES (9, 'Simulation');
INSERT INTO Genre VALUES (10, 'Sport');
INSERT INTO Genre VALUES (11, 'TPS');
INSERT INTO Genre VALUES (12, 'Action');
INSERT INTO Genre VALUES (13, 'Survie');
INSERT INTO Genre VALUES (14, 'Création');
INSERT INTO Genre VALUES (15, 'Fantastique');
INSERT INTO Genre VALUES (16, 'Combat');
INSERT INTO Genre VALUES (17, 'Stratégie');
INSERT INTO Genre VALUES (18, 'Party-Game');

INSERT INTO Plateforme VALUES (1, 'Playstation 4');
INSERT INTO Plateforme VALUES (2, 'Xbox One');
INSERT INTO Plateforme VALUES (3, 'Switch');
INSERT INTO Plateforme VALUES (4, 'PC');

INSERT INTO Produit VALUES (1, 'Red Dead Redemption 2 PS4', 'Amérique, 1899. L''ère de l''Ouest sauvage touche à sa fin alors que les autorités ont décidé de traquer les dernières bandes de hors-la-loi qui sévissent encore. Ceux qui ne se rendent pas ou résistent sont tués. <br><br>Suite à un braquage qui a mal tourné dans la ville de Blackwater, Arthur Morgan et le reste des hors-la-loi de la bande de Dutch van der Linde doivent prendre la fuite vers l''est. Les agents fédéraux et les meilleurs chasseurs de primes du pays se mettent à leurs trousses et la bande commet méfaits sur méfaits dans les vastes terres sauvages de l''Amérique dans un seul et unique but : survivre. Alors que des querelles internes menacent de faire voler la bande en éclats, Arthur est tiraillé entre ses propres idéaux et sa loyauté envers la bande qui l''a élevé.<br><br>Par les créateurs de Grand Theft Auto V et Red Dead Redemption, Red Dead Redemption 2 raconte une histoire épique au cœur de l''Amérique à l''aube de l''ère moderne.');
INSERT INTO Produit VALUES (2, 'Death Stranding PS4', 'Le légendaire créateur de jeu vidéo Hideo Kojima revient avec un nouveau jeu d''action-aventure en monde ouvert unique en son genre sur PlayStation 4. Avec Norman Reedus, Mads Mikkelsen, Léa Seydoux et Lindsay Wagner.<br><br>Dans un futur proche, des explosions mystérieuses ont secoué la planète et déclenché une suite d''événements surnaturels, le Death Stranding. Alors que des créatures mystiques envahissent le paysage et qu''une extinction massive est imminente, Sam Porter Bridges doit voyager à travers les terres dévastées pour sauver l''humanité de l''annihilation.<br><br>Affrontez un monde radicalement transformé par le Death Stranding.<br><br>Transportez les vestiges dissociés de notre futur et embarquez dans une aventure pour reconnecter, pas après pas, un monde détruit.');
INSERT INTO Produit VALUES (3, 'NBA 2k20 PS4', 'NBA 2K est devenu bien plus qu''une simulation de basket. 2K continue de redéfinir les limites des jeux de sport avec NBA 2K20, son gameplay, ses graphismes, ses modes de jeu, un contrôle des joueurs et des options de personnalisation révolutionnaires. De plus, grâce à son monde ouvert immersif, NBA 2K20 est une plateforme où se rassemblent les amoureux du ballon, réels comme virtuels, afin de créer la culture du basket de demain.');
INSERT INTO Produit VALUES (4, 'Borderlands 3 PS4', 'Le jeu de tir de référence est de retour avec ses trilliards de flingues pour une aventure démente ! Découvrez de nouveaux mondes et affrontez vos ennemis avec l''un des quatre Chasseurs de l''Arche proposés, des héros en quête de trésors avec chacun leurs propres compétences et options de personnalisation. Jouez en solo ou en coop pour sauver la galaxie d''une secte et de ses leaders sans pitié.');
INSERT INTO Produit VALUES (5, 'Star Wars Jedi PS4', 'Une aventure galactique vous attend dans Star Wars Jedi: Fallen Order, le nouveau jeu d''action-aventure à la 3e personne développé par Respawn Entertainment. Dans ce jeu narratif en solo, vous incarnez un Padawan Jedi qui a échappé de justesse à la purge de l''Ordre 66 après les événements de l''Épisode 3 : La revanche des Sith. Afin de reconstruire l''Ordre Jedi, vous devrez rassembler les pièces de votre passé brisé pour terminer votre entraînement, développer de nouvelles capacités liées à la Force et apprendre à maîtriser votre célèbre sabre laser, tout en gardant une longueur d''avance sur l''Empire et ses impitoyables Inquisiteurs.<br><br>En maîtrisant leurs capacités, les joueurs devront livrer des combats de Force et de sabres laser aussi intenses que ceux des films Star Wars. Pour venir à bout de leurs ennemis, ils devront faire preuve d''astuce, évaluer leurs forces et leurs faiblesses, et utiliser habilement leur entraînement de Jedi pour remporter les combats et résoudre les énigmes qu''ils rencontreront en chemin.<br><br>Les fans de Star Wars reconnaîtront des lieux, des armes, des équipements et des ennemis emblématiques, et découvriront de nouveaux personnages, des décors, des créatures, des droïdes et des adversaires inédits dans Star Wars. Dans cette authentique histoire Star Wars, les fans plongeront au cœur d''une galaxie récemment tombée aux mains de l''Empire. Au cours de leur fuite, ils devront démontrer leur courage de Jedi, se battre pour survivre et explorer les mystères d''une civilisation éteinte depuis bien longtemps, en s''efforçant de reconstruire les vestiges de l''Ordre Jedi que l''Empire tente par tous les moyens de réduire à néant.');
INSERT INTO Produit VALUES (6, 'Minecraft PS4', 'Minecraft consiste à réaliser des constructions en agençant des blocs et de partir à l''aventure. Explorez des mondes générés aléatoirement et réalisez toutes sortes de constructions, de la plus humble maisonnette au plus fantastique des châteaux. Jouez avec des ressources illimitées en mode Créatif, ou allez en collecter dans les profondeurs de votre monde en mode Survie pour fabriquer armes et armures afin de repousser les hordes d''ennemis qui rôdent.');
INSERT INTO Produit VALUES (7, 'Spider Man PS4', 'Mettant en vedette l''un des héros les plus emblématiques de la planète, le nouveau Spider-Man vous offre toutes les acrobaties, les improvisations, et les déplacements de building en building que vous attendez, tout en vous surprenant avec des éléments jamais vus dans un jeu Spider-Man.<br><br>Maîtrisez l''art du parkour dans des environnements interactifs uniques, faites face à de nouveaux combats et à des scènes d''action dignes d''un blockbuster. Découvrez Spider-Man comme vous ne l''avez jamais vu !');
INSERT INTO Produit VALUES (8, 'Ark PS4', 'Préparez-vous pour l''aventure suprême sur le thème des dinosaures! Abandonné sur une mystérieuse île préhistorique, vous devez explorer ses vastes biomes tout en commençant à chasser, à récolter, à fabriquer des outils, à cultiver et à bâtir des abris pour survivre. Utilisez votre ruse et vos compétences pour tuer, apprivoiser et élever des dinosaures et d''autres bêtes primitives vivant sur « The ARK », et même monter dessus! Faites progresser votre technologie d''outils primitifs en pierre jusqu''à des canons laser fixés à des tyrannosaures, en travaillant avec des centaines de joueurs en ligne ou en profitant d''une expérience jurassique solitaire.');
INSERT INTO Produit VALUES (9, 'Resident Evil 2 PS4', 'Sorti à l''origine en 1998, Resident Evil 2, l''un des jeux les plus emblématiques de son époque, revient dans une version entièrement révisée pour les consoles nouvelles générations.<br><br>Jouez aux campagnes individuelles de Leon Kennedy et Claire Redfield dans une toute nouvelle vue objective et explorez les quartiers infestés de zombies de Raccoon City, entièrement remodelée grâce au RE Engine de Capcom. Les énigmes, intrigues et zones inédites sauront terrifier les nouveaux venus aussi bien que les fans les plus chevronnés !');
INSERT INTO Produit VALUES (10, 'AC Odyssey PS4', 'Écrivez votre propre odyssée et vivez d''incroyables aventures dans un monde où importe chacun de vos choix. Condamné à mort par votre propre famille, vous êtes un mercenaire et vous embarquez pour un voyage épique, où vous passerez du statut de paria à celui de légende, et lèverez le voile sur les secrets de votre passé. Tracez votre propre chemin à travers un monde déchiré par la guerre, façonné par les Dieux et où les montagnes jaillissent de la mer. Rencontrez les figures historiques de la Grèce antique et prenez part à des évènements qui ont constitué un véritable tournant dans l''Histoire et marqué la civilisation occidentale.<br><br>Assassin''s Creed® Odyssey offre aux joueurs une liberté de choix inédite grâce à des fonctionnalités jamais vues auparavant dans la saga Assassin''s Creed. Choisissez le héros que vous souhaitez incarner et qui impactera le monde autour de vous. Rencontrez des personnages hauts en couleur et prenez des décisions qui changeront le cours de votre Odyssée ; vous seuls êtes aux commandes de votre destin. Personnalisez votre équipement et maîtrisez de nouvelles capacités spéciales en vous créant un panel de compétences adapté à votre style de combat. Frayez-vous un chemin à travers la Grèce, participez à des batailles épiques sur terre et en mer pour devenir un véritable héros de légende.');
INSERT INTO Produit VALUES (11, 'PES 2020 PS4', 'eFootball PES 2020 est le dernier opus de la simulation de football. Le jeu intègre une série de nouveautés telles qu''une version remasterisée de la Master League et le style de Ronaldinho avec tout lot de mouvements et de techniques.');
INSERT INTO Produit VALUES (12, 'Devil May Cry 5 PS4', 'Des années s''étaient écoulées sans que les légions de l''Enfer ne se soient manifestées, mais une nouvelle invasion démoniaque vient de débuter dans la ville de Red Grave. Le dernier espoir de l''humanité repose dans les mains de trois chasseurs de démons solitaires, proposant chacun un style de combat radicalement différent. Unis par le destin et la soif de vengeance, ces êtres exceptionnels se préparent à l''affrontement ultime contre les plus terribles représentants des forces des ténèbres.<br><br>Devil May Cry 5 est un beat''em all nouvelle génération qui fait toujours la part belle aux personnages ultra-charismatiques et aux enchainements au style imparables. Il bénéficie des dernières technologies du RE Engine et du savoir-faire de l''équipe expérimentée du producteur Hideaki Itsuno pour proposer le titre le plus abouti et le plus spectaculaire de la saga.');
INSERT INTO Produit VALUES (13, 'Jumanji PS4', 'Partez pour une aventure palpitante et désopilante avec Jumanji, et tentez de survivre au défi ultime pour ceux qui espèrent laisser derrière eux leur univers.<br><br>Seuls vous et vos 3 coéquipiers pourront retrouver les JOYAUX et sauver Jumanji. Lancez-vous en ligne, rassemblez vos amis pour jouer sur écran scindé ou entourez-vous de compagnons gérés par l''IA. Affrontez une armée de sbires malintentionnés, échappez aux bêtes féroces et aux pièges mortels, et débloquez de superbes options de personnalisation. Avec des héros comme le Dr Bravestone, Ruby, Mouse et le prof. Oberon en tant qu''avatars, vous disposerez des capacités nécessaires pour sauver le monde... Ce qui ne vous empêchera pas d''échouer parfois de manière spectaculaire !');
INSERT INTO Produit VALUES (14, 'Dragonball Fighter Z PS4', 'Après le succès de la série Xenoverse, il est temps de présenter un nouveau jeu de combat Dragon Ball en 2D pour les nouvelles générations de consoles.<br><br>DRAGON BALL FighterZ reprend les éléments qui ont fait le succès de la série DRAGON BALL : des combats spectaculaires avec des combattants aux pouvoirs incroyables.<br><br>Développé par Arc System Works, DRAGON BALL FighterZ repousse la qualité des graphismes à un niveau jamais vu encore et met sur pieds un gameplay facile d''accès mais difficile à maîtriser pour les joueurs du monde entier.');
INSERT INTO Produit VALUES (15, 'Red Dead Redemption 2 XONE', 'Amérique, 1899. L''ère de l''Ouest sauvage touche à sa fin alors que les autorités ont décidé de traquer les dernières bandes de hors-la-loi qui sévissent encore. Ceux qui ne se rendent pas ou résistent sont tués. <br><br>Suite à un braquage qui a mal tourné dans la ville de Blackwater, Arthur Morgan et le reste des hors-la-loi de la bande de Dutch van der Linde doivent prendre la fuite vers l''est. Les agents fédéraux et les meilleurs chasseurs de primes du pays se mettent à leurs trousses et la bande commet méfaits sur méfaits dans les vastes terres sauvages de l''Amérique dans un seul et unique but : survivre. Alors que des querelles internes menacent de faire voler la bande en éclats, Arthur est tiraillé entre ses propres idéaux et sa loyauté envers la bande qui l''a élevé.<br><br>Par les créateurs de Grand Theft Auto V et Red Dead Redemption, Red Dead Redemption 2 raconte une histoire épique au cœur de l''Amérique à l''aube de l''ère moderne.');
INSERT INTO Produit VALUES (16, 'Star Wars Jedi XONE', 'Une aventure galactique vous attend dans Star Wars Jedi: Fallen Order, le nouveau jeu d''action-aventure à la 3e personne développé par Respawn Entertainment. Dans ce jeu narratif en solo, vous incarnez un Padawan Jedi qui a échappé de justesse à la purge de l''Ordre 66 après les événements de l''Épisode 3 : La revanche des Sith. Afin de reconstruire l''Ordre Jedi, vous devrez rassembler les pièces de votre passé brisé pour terminer votre entraînement, développer de nouvelles capacités liées à la Force et apprendre à maîtriser votre célèbre sabre laser, tout en gardant une longueur d''avance sur l''Empire et ses impitoyables Inquisiteurs.<br><br>En maîtrisant leurs capacités, les joueurs devront livrer des combats de Force et de sabres laser aussi intenses que ceux des films Star Wars. Pour venir à bout de leurs ennemis, ils devront faire preuve d''astuce, évaluer leurs forces et leurs faiblesses, et utiliser habilement leur entraînement de Jedi pour remporter les combats et résoudre les énigmes qu''ils rencontreront en chemin.<br><br>Les fans de Star Wars reconnaîtront des lieux, des armes, des équipements et des ennemis emblématiques, et découvriront de nouveaux personnages, des décors, des créatures, des droïdes et des adversaires inédits dans Star Wars. Dans cette authentique histoire Star Wars, les fans plongeront au cœur d''une galaxie récemment tombée aux mains de l''Empire. Au cours de leur fuite, ils devront démontrer leur courage de Jedi, se battre pour survivre et explorer les mystères d''une civilisation éteinte depuis bien longtemps, en s''efforçant de reconstruire les vestiges de l''Ordre Jedi que l''Empire tente par tous les moyens de réduire à néant.');
INSERT INTO Produit VALUES (17, 'Borderlands 3 XONE', 'Le jeu de tir de référence est de retour avec ses trilliards de flingues pour une aventure démente ! Découvrez de nouveaux mondes et affrontez vos ennemis avec l''un des quatre Chasseurs de l''Arche proposés, des héros en quête de trésors avec chacun leurs propres compétences et options de personnalisation. Jouez en solo ou en coop pour sauver la galaxie d''une secte et de ses leaders sans pitié.');
INSERT INTO Produit VALUES (18, 'FIFA 20 XONE', 'Doté du moteur Frostbite™, EA SPORTS™ FIFA 20 sur PlayStation®4, Xbox One et PC vous propose deux facettes du Jeu Universel : le prestige du football professionnel et une nouvelle expérience réaliste de street football avec EA SPORTS VOLTA. FIFA 20 innove sur tous les plans : le FOOTBALL INTELLIGENT vous offre un réalisme sans précédent, FIFA Ultimate Team™ vous propose de nouvelles façons de créer votre équipe de rêve et EA SPORTS VOLTA vous plonge dans le monde du street avec des terrains réduits.');
INSERT INTO Produit VALUES (19, 'NBA 2k20 XONE', 'NBA 2K est devenu bien plus qu''une simulation de basket. 2K continue de redéfinir les limites des jeux de sport avec NBA 2K20, son gameplay, ses graphismes, ses modes de jeu, un contrôle des joueurs et des options de personnalisation révolutionnaires. De plus, grâce à son monde ouvert immersif, NBA 2K20 est une plateforme où se rassemblent les amoureux du ballon, réels comme virtuels, afin de créer la culture du basket de demain.');
INSERT INTO Produit VALUES (20, 'NFS Heat XONE', 'Pilotez le jour et risquez tout la nuit dans Need for Speed™ Heat, une expérience palpitante qui vous met au défi d''intégrer l''élite de la course urbaine face à de redoutables policiers corrompus. Le jour, participez au Speedhunter Showdown, une compétition officielle où vous gagnerez de quoi personnaliser et améliorer les voitures performantes contenues dans votre garage. Une fois votre bagnole relookée et gonflée à bloc, et que vous vous sentez d''attaque pour vivre des moments intenses, affrontez d''autres pilotes la nuit, avec votre crew, lors de courses illégales grâce auxquelles vous vous taillerez une réputation et vous accéderez à de meilleures pièces et à des courses plus relevées. Mais sous couvert de patrouilles nocturnes, des flics corrompus veulent vous arrêter et confisquer tout ce que vous aurez gagné. Prenez des risques et devenez encore plus célèbre en leur tenant tête, ou rentrez à votre planque pour vivre une nouvelle journée de courses. Courses, risques, voitures : ici, les limites n''existent pas. Votre crew prend les mêmes risques que vous, votre garage déborde de belles voitures, et la ville est votre terrain de jeu, 24 heures sur 24.');
INSERT INTO Produit VALUES (21, 'Civilization VI XONE', 'Pour la toute première fois sur PlayStation®4 et Xbox One, entrez dans l''histoire avec Sid Meier''s Civilization VI. Explorez le monde, faites progresser votre culture, partez en guerre et négociez la paix face aux plus grands dirigeants de l''humanité, pour tenter de bâtir un empire capable de résister au passage du temps.<br><br>Sid Meier''s Civilization VI est le dernier jeu en date de la célèbre franchise, sorti en 2016 et récompensé par la critique (meilleur jeu de stratégie aux Games Awards et aux DICE Awards).');
INSERT INTO Produit VALUES (22, 'COD MW XONE', 'Préparez-vous pour le retour de Modern Warfare® !<br><br>Dans un tout nouvel opus aux enjeux plus élevés que jamais, les joueurs incarneront des agents d''élite des forces spéciales pris dans l''engrenage haletant d''un conflit à l''échelle globale qui menace l''équilibre du pouvoir. Call of Duty®: Modern Warfare® entrainera les joueurs dans une expérience à l''intensité sans pareille, brute, sombre et provocatrice ; mettant en avant la nature changeante de la guerre contemporaine. Développé par le studio Infinity Ward à l''origine de la série, Call of Duty: Modern Warfare propose une expérience épique, réimaginée de fond en comble.<br><br>À travers une Campagne solo viscérale et sans concessions, Call of Duty: Modern Warfare repousse les limites de la série vers des sommets que seul Modern Warfare est capable d''atteindre. Aux côtés d''agents des forces spéciales internationales et de combattants de la liberté, les joueurs prendront part à des opérations secrètes qui les conduiront aux quatre coins du globe, dans des villes emblématiques d''Europe et jusqu''aux confins du Moyen-Orient.<br><br>Et l''histoire ne fait que commencer.<br><br>Dans Call of Duty: Modern Warfare, les joueurs seront plongés dans une trame narrative palpitante qui se prolongera à travers tous les aspects du jeu. Plongez dans l''expérience en ligne ultime avec le célèbre mode Multijoueur adoubé par les fans, ou prenez part à une série d''opérations d''élite en coopération accessibles pour les joueurs de tous niveaux.');
INSERT INTO Produit VALUES (23, 'Star Wars BF XONE', 'Vivez l''aventure de votre propre héros Star WarsT.<br><br>Embarquez pour une aventure Star WarsT pleine d''action avec le nouvel opus de la série de jeux HD Star Wars la plus vendue au monde.<br><br>Affrontez des vagues d''ennemis grâce au pouvoir de votre sabre laser sur la base Starkiller. Prenez d''assaut la jungle dissimulant la base rebelle sur Yavin 4 et déchaînez la puissance de feu de vos TR-TT. Menez votre escadron de X-wings dans l''espace pour attaquer un destroyer stellaire géant du<br><br>Premier Ordre. Ou incarnez un nouveau héros Star Wars, Iden, soldat d''élite des forces spéciales impériales, et découvrez un scénario solo émouvant et prenant qui s''étend sur trente ans.<br><br>Profitez d''une expérience multijoueur Star Wars riche et pleine de vie avec des cartes englobant les trois générations : préquelle, classique et nouvelle trilogie. Personnalisez et améliorez vos héros, vos vaisseaux et vos soldats, chacun disposant de pouvoirs uniques à utiliser en combat. Chevauchez des tauntauns ou prenez le contrôle de tanks et de motojets. Détruisez des destroyers stellaires aussi grands que des villes, ou servez-vous de la Force pour prouver votre valeur face à des personnages emblématiques tels que Kylo Ren, Dark Maul ou Han Solo, dans cette expérience inspirée par 40 ans de films Star Wars intemporels.<br><br>Vous pourrez vivre l''aventure de votre propre héros Star Wars.');
INSERT INTO Produit VALUES (24, 'Forza 7 XONE', 'Le jeu de course le plus beau, complet et authentique jamais créé.');
INSERT INTO Produit VALUES (25, 'GTA V XONE', 'Los Santos : une métropole tentaculaire avec ses gourous, ses starlettes et ses gloires du passé fanées qui faisaient jadis rêver le monde entier et qui, aujourd''hui, luttent pour ne pas sombrer dans l''oubli alors que le pays est rongé par la crise. Au milieu de ce chaos ensoleillé, trois criminels très différents jouent gros pour leur avenir : Franklin, un ancien membre de gang de rue qui veut passer à la vitesse supérieure ; Michael, le professionnel, un ex-détenu dont la retraite est beaucoup moins tranquille que prévue ; et enfin Trevor, le psychopathe du groupe, camé et mégalo. Le dos au mur, les trois hommes risquent le tout pour le tout dans une série de braquages aussi spectaculaires que dangereux.<br><br>Loin au-dessus de l''agitation des rues de Los Santos, le dirigeable Atomic survole l''usine qui fabrique les meilleurs pneus de la ville (et dont les articles sont en vente dans tous les LS Customs). Précommandez maintenant pour pouvoir, vous aussi, survoler la ville de Los Santos en toute tranquillité aux commandes de l''appareil le plus emblématique qui soit.');
INSERT INTO Produit VALUES (26, 'Sniper Ghost XONE', 'Vivez l''expérience d''un jeu de tireur d''élite ultra réaliste, sur le terrain diffcile de la Sibérie moderne, avec un tout nouveau système de contrats qui encourage la réfexion stratégique lors de missions captivantes et redéployables. Contracts propose des missions sur mesure qui affichent un objectif principal clair avec une récompense financière fixe et des objectifs secondaires optionnels pour des paiements de bonus additionnels. Avec des centaines de façons d''abattre un large éventail de cibles, Contracts offre le nec plus ultra du gameplay de tireur d''élite.');
INSERT INTO Produit VALUES (27, 'Pokemon Epee SWITCH', 'Nouvelle région, nouveaux Pokémon, nouvelles règles : préparez-vous, la nouvelle génération de Pokémon arrive en 2019.<br><br>Dresseur ou Dresseuse, débutez votre aventure dans la fascinante région de Galar, inspirée de l''Angleterre de la Révolution Industrielle, où les combats Pokémon sont élevés au rang d''événements sportifs dans des stades. De tous nouveaux Pokémon vous attendent dans des environnements variés : vallées, montagnes, forêts et surtout, les Terres sauvages, des zones en monde ouvert où se déplacent librement les Pokémon sauvages ! Nouveauté colossale de cet opus, le phénomène Dynamax : il amplifie considérablement la taille de vos Pokémon en combat et, quand il est déployé par un Pokémon sauvage, seule une alliance de dresseurs chevronnés peut en venir à bout !');
INSERT INTO Produit VALUES (28, 'Luigi Mansion SWITCH', 'Le plus courageux des froussards est de retour dans la suite d''un des plus grands succès de la Nintendo 3DS, avec Luigi''s Mansion 3 ! Après avoir reçu une invitation à séjourner dans un hôtel luxueux, Luigi se prépare à passer des vacances idylliques avec Mario et ses amis. Le rêve tourne rapidement au cauchemar lorsque le Roi Boo révèle que tout cela n''était qu''un stratagème pour capturer Mario et ses compagnons ! Une nouvelle fois assisté du farfelu professeur K. Tastroff, c''est au plus trouillard des téméraires de s''aventurer dans l''exploration d''un hôtel qui n''a rien d''une destination idéale…<br><br>Incarnez Luigi et partez à la chasse aux fantômes avec votre aspirateur à spectres : l''Ectoblast GL-U ! Pour la première fois, faites aussi appel à Gluigi, un double de Luigi vert et gluant, pour vous aider à franchir les obstacles insurmontables tout seul. Jouez en solo, en alternant entre Luigi et Gluigi pour résoudre les énigmes, ou en coopération et contrôlez chacun un personnage. En famille ou entre amis, jouez jusqu''à 8 joueurs et tentez de résoudre les missions de la Tour Hantée ! La chasse aux fantômes reprend de plus belle dans Luigi''s Mansion 3, exclusivement sur Nintendo Switch et Nintendo Switch Lite !');
INSERT INTO Produit VALUES (29, 'Mario Sonic JO SWITCH', 'Rendez-vous aux Jeux Olympiques de Tokyo 2020 avec Mario, Sonic et leurs amis en exclusivité sur Nintendo Switch ! Tentez de remporter la médaille d''or en donnant le maximum dans des disciplines bourrées d''action, parmi lesquelles une large panoplie de sports classiques mais également le skateboard, le karaté, le surf et l''escalade sportive, présents pour la première fois aux J.O. de Tokyo 2020. Allumez votre Nintendo Switch, et que la compétition commence ! Différentes façons de jouer s''offrent à vous : vous pouvez utiliser les boutons aussi bien que les commandes par mouvements, dans des modes de jeu multijoueur où peuvent s''affronter jusqu''à quatre joueurs en local et jusqu''à huit joueurs en ligne.<br><br>Incarnez Mario, Sonic, Yoshi, Amy Rose, Luigi, Dr. Eggman et bien d''autres personnages ! La course aux médailles d''or débarque exclusivement sur Nintendo Switch en novembre 2019 !');
INSERT INTO Produit VALUES (30, 'Pokemon Bouclier SWITCH', 'Nouvelle région, nouveaux Pokémon, nouvelles règles : préparez-vous, la nouvelle génération de Pokémon arrive en 2019.<br><br>Dresseur ou Dresseuse, débutez votre aventure dans la fascinante région de Galar, inspirée de l''Angleterre de la Révolution Industrielle, où les combats Pokémon sont élevés au rang d''événements sportifs dans des stades. De tous nouveaux Pokémon vous attendent dans des environnements variés : vallées, montagnes, forêts et surtout, les Terres sauvages, des zones en monde ouvert où se déplacent librement les Pokémon sauvages ! Nouveauté colossale de cet opus, le phénomène Dynamax : il amplifie considérablement la taille de vos Pokémon en combat et, quand il est déployé par un Pokémon sauvage, seule une alliance de dresseurs chevronnés peut en venir à bout !');
INSERT INTO Produit VALUES (31, 'Mario Kart 8 SWITCH', 'Appuyez sur le champignon et affûtez vos carapaces, Mario Kart 8 Deluxe va tout retourner sur<br><br>Nintendo Switch ! Foncez à fond les ballons la tête à l''envers avec les pneus anti-gravité ! Irez-vous plus vite en passant par le plafond ? Ou allez-vous tracer au sol entre les bananes et les batailles de carapace ? Tous les coups les plus fourbes sont permis pour se hisser à la première place !<br><br>Maîtrisez tous les pouvoirs comme la plume pour éviter les mauvaises surprises, ou encore le fantôme pour devenir invisible dans les 48 circuits légendaires ! D''autant plus que de nouveaux invités de marque s''invitent à la fête comme le roi Boo ou encore les Inklings de Splatoon !<br><br>Sous l''eau, dans les airs, en moto, en deltaplane ou en kart, contrôlez dérapages et lancers de boomerang et commencez une partie de Mario Kart sur la TV de votre salon, avant de rejoindre vos amis dans un avion pour continuer à balancer des carapaces en multi-joueur, dès le 28 avril !');
INSERT INTO Produit VALUES (32, 'Mario Party SWITCH', 'La série Mario Party débarque sur Nintendo Switch avec un gameplay et des mini-jeux survoltés pour tous ! Le jeu de plateau original a été agrémenté de nouveaux éléments stratégiques, comme les dés propres à chaque personnage. Le jeu propose également de toutes nouvelles manières de jouer, des mini-jeux spécialement conçus pour tirer parti des Joy-Con et de nouveaux modes pour s''amuser en famille ou entre amis. Le jeu de plateau oppose quatre joueurs dans une course folle où chacun joue l''un après l''autre sur le plateau pour trouver des Étoiles. Vous pouvez également associer deux consoles Nintendo Switch pour profiter d''un style de jeu dynamique comme dans le nouveau mode "Salle de jeux de Toad". Et pour la première fois dans la série, mesurez vos compétences à celles d''autres fans de Mario Party à travers un tout nouveau mode de mini-jeux en ligne. Avec ces nouveaux modes et une ribambelle de mini-jeux inédits regroupés dans un jeu de plateau original, vous pourrez faire la fête où et quand vous le souhaitez avec des joueurs de tous horizons. Points forts Une diversité de modes, dont : - Mario Party : profitez de l''expérience de jeu de plateau Mario Party originale avec de nouveaux éléments comme les dés propres à chaque personnage ou de nouveaux plateaux à explorer ! - Mario Party en duos : mode de bataille coopératif en équipe avec déplacements libres sur le plateau. - Online Mariothon : un must dans la série Mario Party ! Jouez à une série de cinq mini-jeux en ligne. - Salle de jeux de Toad : ce nouveau style de jeu dynamique associe deux consoles Nintendo Switch en mode sur table. La compétition fait rage dans les 80 nouveaux mini-jeux aux innombrables façons de jouer ! - Des mini-jeux frénétiques et rapides qui exploitent les Joy-Con de manières différentes.');
INSERT INTO Produit VALUES (33, 'Super Smash Bros Ultimate SWITCH', 'Des mondes de jeux et des combattants légendaires se retrouvent pour l''affrontement ultime dans le nouvel opus de la série Super Smash Bros. sur Nintendo Switch ! De nouveaux combattants comme l''Inkling de la série Splatoon et Ridley de la série Metroid, font leur débuts dans Super Smash Bros. aux côtés de tous les combattants ayant jamais figuré dans la série Super Smash Bros. !');
INSERT INTO Produit VALUES (34, 'Minecraft SWITCH', 'Minecraft consiste à réaliser des constructions en agençant des blocs et de partir à l''aventure. Explorez des mondes générés aléatoirement et réalisez toutes sortes de constructions, de la plus humble maisonnette au plus fantastique des châteaux. Jouez avec des ressources illimitées en mode Créatif, ou allez en collecter dans les profondeurs de votre monde en mode Survie pour fabriquer armes et armures afin de repousser les hordes d''ennemis qui rôdent.<br><br>Mais explorer et construire ce monde ne se fait pas forcément en solitaire : jusqu''à huit bâtisseurs peuvent jouer ensemble en ligne*, tandis qu''on peut jouer à quatre en multijoueur local, en mode téléviseur ou en mode sur table, qui est compatible à la fois avec la manette Nintendo Switch Pro (vendue séparément) et le jeu en écran partagé.<br><br>Les fans de Nintendo comme ceux de Minecraft seront aussi ravis d''apprendre que le Super Mario Mash-Up Pack sera également disponible dans la version Nintendo Switch. Amusez-vous à explorer un monde rempli de personnages et de lieux de l''univers de Mario !');
INSERT INTO Produit VALUES (35, 'Zelda BOTW SWITCH', 'Entrez dans un monde d''aventure<br><br>Oubliez tout ce que vous savez sur les jeux The Legend of Zelda. Plongez dans un monde de découverte, d''exploration et d''aventure dans The Legend of Zelda: Breath of the Wild, un nouveau jeu qui vient bouleverser la série à succès. Voyagez à travers champs, traversez des forêts et grimpez sur des sommets dans votre périple où vous explorez le royaume d''Hyrule en ruines à travers cette aventure à ciel ouvert.');
INSERT INTO Produit VALUES (36, 'Farming Simulator SWITCH', 'Avec Farming Simulator, faites prospérer votre ferme et conduisez plus d''une centaine de véhicules et engins des plus grandes marques agricoles, fidèlement reproduits en jeu. Pour la première fois sur Nintendo Switch, le numéro 1 mondial John Deere rejoint le garage de Farming Simulator aux côtés de Case IH, New Holland, Challenger, Fendt, Valtra, Kröne, Deutz-Fahr, et des bien d''autres ! Développez votre ferme sur un nouvel environnement Nord-Américain et participez à de nombreuses activités aussi riches que variées, incluant des cultures inédites sur Nintendo Switch comme le coton et l''avoine, ainsi que leur équipement dédié. Prenez soin de votre bétail tel que les cochons, les vaches et les moutons, et explorez désormais vos terres à dos de cheval !');
INSERT INTO Produit VALUES (37, 'GTA V PC', 'Los Santos : une métropole tentaculaire avec ses gourous, ses starlettes et ses gloires du passé fanées qui faisaient jadis rêver le monde entier et qui, aujourd''hui, luttent pour ne pas sombrer dans l''oubli alors que le pays est rongé par la crise. Au milieu de ce chaos ensoleillé, trois criminels très différents jouent gros pour leur avenir : Franklin, un ancien membre de gang de rue qui veut passer à la vitesse supérieure ; Michael, le professionnel, un ex-détenu dont la retraite est beaucoup moins tranquille que prévue ; et enfin Trevor, le psychopathe du groupe, camé et mégalo. Le dos au mur, les trois hommes risquent le tout pour le tout dans une série de braquages aussi spectaculaires que dangereux.<br><br>Loin au-dessus de l''agitation des rues de Los Santos, le dirigeable Atomic survole l''usine qui fabrique les meilleurs pneus de la ville (et dont les articles sont en vente dans tous les LS Customs). Précommandez maintenant pour pouvoir, vous aussi, survoler la ville de Los Santos en toute tranquillité aux commandes de l''appareil le plus emblématique qui soit.');
INSERT INTO Produit VALUES (38, 'Farming Simulator PC', 'Avec Farming Simulator, faites prospérer votre ferme et conduisez plus d''une centaine de véhicules et engins des plus grandes marques agricoles, fidèlement reproduits en jeu. Pour la première fois sur Nintendo Switch, le numéro 1 mondial John Deere rejoint le garage de Farming Simulator aux côtés de Case IH, New Holland, Challenger, Fendt, Valtra, Kröne, Deutz-Fahr, et des bien d''autres ! Développez votre ferme sur un nouvel environnement Nord-Américain et participez à de nombreuses activités aussi riches que variées, incluant des cultures inédites sur Nintendo Switch comme le coton et l''avoine, ainsi que leur équipement dédié. Prenez soin de votre bétail tel que les cochons, les vaches et les moutons, et explorez désormais vos terres à dos de cheval !');
INSERT INTO Produit VALUES (39, 'Farcry New Dawn PC', 'Dix-sept ans après une catastrophe nucléaire mondiale, la civilisation humaine émerge à peine du chaos et se retrouve aux prises avec un tout nouveau monde. A Hope County, au Montana, les survivants ont formé différents groupes, chacun définissant ses propres règles de survie.<br><br>Les Ravageurs, un vicieux groupe d''individus dirigé par les terribles sœurs jumelles Mickey et Lou, saccagent tout sur leur passage et tuent pour piller les quelques ressources disponibles. Alors que les Survivants tentent de lutter pour protéger leurs terres des virulentes attaques des Ravageurs, ce sera à vous de décider si vous souhaitez leur venir en aide et mener à bien ce combat.<br><br>Dans ce tout dernier opus de la très acclamée franchise Far Cry, vous incarnez le dernier espoir de résistance dans un Hope County totalement transformé et post-apocalyptique. Aidez la communauté des Survivants à se consolider, fabriquez vos propres armes pour mener à bien les guerres de territoire et les Expéditions à travers les pays, et formez des alliances improbables pour survivre dans ce nouvel ordre naturel, plus hostile que jamais.');
INSERT INTO Produit VALUES (40, 'Resident Evil 2 PC', 'Sorti à l''origine en 1998, Resident Evil 2, l''un des jeux les plus emblématiques de son époque, revient dans une version entièrement révisée pour les consoles nouvelles générations.<br><br>Jouez aux campagnes individuelles de Leon Kennedy et Claire Redfield dans une toute nouvelle vue objective et explorez les quartiers infestés de zombies de Raccoon City, entièrement remodelée grâce au RE Engine de Capcom. Les énigmes, intrigues et zones inédites sauront terrifier les nouveaux venus aussi bien que les fans les plus chevronnés !');
INSERT INTO Produit VALUES (41, 'Borderlands 3 PC', 'Le jeu de tir de référence est de retour avec ses trilliards de flingues pour une aventure démente ! Découvrez de nouveaux mondes et affrontez vos ennemis avec l''un des quatre Chasseurs de l''Arche proposés, des héros en quête de trésors avec chacun leurs propres compétences et options de personnalisation. Jouez en solo ou en coop pour sauver la galaxie d''une secte et de ses leaders sans pitié.');
INSERT INTO Produit VALUES (42, 'Wolfenstein 2 PC', 'Wolfenstein II: The New Colossus est la suite très attendue de Wolfenstein: The New Order, le jeu de tir à la première personne développé par les talentueuses équipes du studio MachineGames.<br><br>Wolfenstein II plonge les joueurs au cœur d''une Amérique contrôlée par les nazis, avec pour objectif de rassembler les plus grands leaders de la résistance encore en vie. Grâce à l''exceptionnel moteur de jeu id Tech® 6, combattez les nazis dans des lieux emblématiques comme le Nouveau-Mexique, les bayous et les boulevards de La Nouvelle-Orléans ou le quartier de Manhattan détruit par un bombardement nucléaire. Profitez de tout un arsenal d''armes exceptionnelles, et déchaînez vos nouvelles capacités sur des bataillons de soldats nazis augmentés et de super-soldats.');
INSERT INTO Produit VALUES (43, 'Borderlands 2 PC', 'Entre jeu de tir à la première personne (FPS) et de jeu de rôle en cel shading, Borderlands 2 donne la possibilité au joueur d''explorer les contrées inconnues des mondes de Pandora. Prenant place 5 ans après la conclusion du premier opus et avec l''aide de quatre nouvelles classes inédites, vous devrez cette fois-ci empêcher le Beau Jack de s''emparer d''une clef légendaire...');
INSERT INTO Produit VALUES (44, 'Overwatch PC', 'Soldats. Scientifiques. Aventuriers. Marginaux.<br><br>Dans une période de crise mondiale, des héros venus de tous les horizons ont composé une équipe d''intervention internationale pour ramener la paix dans un monde déchiré par la guerre : Overwatch.<br><br>Cette organisation a mis fin à la crise et préservé la paix pendant les décennies suivantes, inspiré une ère d''exploration, d''innovation et de découvertes. Mais après bien des années, son influence s''est étiolée, et elle a finalement été dissoute.');

INSERT INTO Editeur VALUES (1, 'Rockstar Games');
INSERT INTO Editeur VALUES (2, 'Sony Interactive Entertainment');
INSERT INTO Editeur VALUES (3, '2K Games');
INSERT INTO Editeur VALUES (4, 'Electronic Arts');
INSERT INTO Editeur VALUES (5, 'Mojang');
INSERT INTO Editeur VALUES (6, 'Studio Wildcard');
INSERT INTO Editeur VALUES (7, 'Ubisoft');
INSERT INTO Editeur VALUES (8, 'Capcom');
INSERT INTO Editeur VALUES (9, 'Outright Games');
INSERT INTO Editeur VALUES (10, 'Bandai Namco Entertainment');
INSERT INTO Editeur VALUES (11, 'Activision');
INSERT INTO Editeur VALUES (12, 'Xbox Game Studios');
INSERT INTO Editeur VALUES (13, 'CI Games');
INSERT INTO Editeur VALUES (14, 'Nintendo');
INSERT INTO Editeur VALUES (15, 'Focus Home Interactive');
INSERT INTO Editeur VALUES (16, 'Bethesda Softworks');
INSERT INTO Editeur VALUES (17, 'Blizzard Entertainment');
INSERT INTO Editeur VALUES (18, 'Konami');

INSERT INTO Jeu VALUES (1, '2018-10-26 00:00:00', 1);
INSERT INTO Jeu VALUES (2, '2019-11-08 00:00:00', 2);
INSERT INTO Jeu VALUES (3, '2019-09-06 00:00:00', 3);
INSERT INTO Jeu VALUES (4, '2019-09-13 00:00:00', 4);
INSERT INTO Jeu VALUES (5, '2019-11-15 00:00:00', 4);
INSERT INTO Jeu VALUES (6, '2009-05-17 00:00:00', 5);
INSERT INTO Jeu VALUES (7, '2018-09-07 00:00:00', 2);
INSERT INTO Jeu VALUES (8, '2015-06-02 00:00:00', 6);
INSERT INTO Jeu VALUES (9, '2019-01-25 00:00:00', 8);
INSERT INTO Jeu VALUES (10, '2018-10-05 00:00:00', 7);
INSERT INTO Jeu VALUES (11, '2019-09-10 00:00:00', 18);
INSERT INTO Jeu VALUES (12, '2019-03-08 00:00:00', 8);
INSERT INTO Jeu VALUES (13, '2019-11-08 00:00:00', 9);
INSERT INTO Jeu VALUES (14, '2018-01-26 00:00:00', 10);
INSERT INTO Jeu VALUES (15, '2018-10-26 00:00:00', 1);
INSERT INTO Jeu VALUES (16, '2019-11-15 00:00:00', 4);
INSERT INTO Jeu VALUES (17, '2019-09-13 00:00:00', 4);
INSERT INTO Jeu VALUES (18, '2019-09-24 00:00:00', 4);
INSERT INTO Jeu VALUES (19, '2019-09-06 00:00:00', 3);
INSERT INTO Jeu VALUES (20, '2019-11-08 00:00:00', 4);
INSERT INTO Jeu VALUES (21, '2016-10-21 00:00:00', 3);
INSERT INTO Jeu VALUES (22, '2019-10-25 00:00:00', 11);
INSERT INTO Jeu VALUES (23, '2019-11-17 00:00:00', 4);
INSERT INTO Jeu VALUES (24, '2017-10-03 00:00:00', 12);
INSERT INTO Jeu VALUES (25, '2013-09-17 00:00:00', 1);
INSERT INTO Jeu VALUES (26, '2017-04-25 00:00:00', 13);
INSERT INTO Jeu VALUES (27, '2019-11-15 00:00:00', 14);
INSERT INTO Jeu VALUES (28, '2019-10-21 00:00:00', 14);
INSERT INTO Jeu VALUES (29, '2019-11-01 00:00:00', 14);
INSERT INTO Jeu VALUES (30, '2019-11-15 00:00:00', 14);
INSERT INTO Jeu VALUES (31, '2017-04-27 00:00:00', 14);
INSERT INTO Jeu VALUES (32, '2018-10-05 00:00:00', 14);
INSERT INTO Jeu VALUES (33, '2018-12-07 00:00:00', 14);
INSERT INTO Jeu VALUES (34, '2020-01-01 00:00:00', 5);
INSERT INTO Jeu VALUES (35, '2017-03-03 00:00:00', 14);
INSERT INTO Jeu VALUES (36, '2019-12-03 00:00:00', 15);
INSERT INTO Jeu VALUES (37, '2013-09-17 00:00:00', 1);
INSERT INTO Jeu VALUES (38, '2019-12-03 00:00:00', 15);
INSERT INTO Jeu VALUES (39, '2019-02-15 00:00:00', 7);
INSERT INTO Jeu VALUES (40, '2019-01-25 00:00:00', 8);
INSERT INTO Jeu VALUES (41, '2019-09-13 00:00:00', 3);
INSERT INTO Jeu VALUES (42, '2017-10-27 00:00:00', 16);
INSERT INTO Jeu VALUES (43, '2012-09-18 00:00:00', 3);
INSERT INTO Jeu VALUES (44, '2016-05-24 00:00:00', 17);

INSERT INTO Pegi_Jeu VALUES(5,1);
INSERT INTO Pegi_Jeu VALUES(6,1);
INSERT INTO Pegi_Jeu VALUES(7,1);
INSERT INTO Pegi_Jeu VALUES(9,1);
INSERT INTO Pegi_Jeu VALUES(5,2);
INSERT INTO Pegi_Jeu VALUES(6,2);
INSERT INTO Pegi_Jeu VALUES(7,2);
INSERT INTO Pegi_Jeu VALUES(1,3);
INSERT INTO Pegi_Jeu VALUES(5,4);
INSERT INTO Pegi_Jeu VALUES(6,4);
INSERT INTO Pegi_Jeu VALUES(7,4);
INSERT INTO Pegi_Jeu VALUES(9,4);
INSERT INTO Pegi_Jeu VALUES(4,5);
INSERT INTO Pegi_Jeu VALUES(6,5);
INSERT INTO Pegi_Jeu VALUES(2,6);
INSERT INTO Pegi_Jeu VALUES(6,6);
INSERT INTO Pegi_Jeu VALUES(8,6);
INSERT INTO Pegi_Jeu VALUES(4,7);
INSERT INTO Pegi_Jeu VALUES(6,7);
INSERT INTO Pegi_Jeu VALUES(4,8);
INSERT INTO Pegi_Jeu VALUES(6,8);
INSERT INTO Pegi_Jeu VALUES(5,9);
INSERT INTO Pegi_Jeu VALUES(6,9);
INSERT INTO Pegi_Jeu VALUES(7,9);
INSERT INTO Pegi_Jeu VALUES(5,10);
INSERT INTO Pegi_Jeu VALUES(6,10);
INSERT INTO Pegi_Jeu VALUES(7,10);
INSERT INTO Pegi_Jeu VALUES(1,11);
INSERT INTO Pegi_Jeu VALUES(5,12);
INSERT INTO Pegi_Jeu VALUES(6,12);
INSERT INTO Pegi_Jeu VALUES(2,13);
INSERT INTO Pegi_Jeu VALUES(6,13);
INSERT INTO Pegi_Jeu VALUES(3,14);
INSERT INTO Pegi_Jeu VALUES(6,14);
INSERT INTO Pegi_Jeu VALUES(7,14);
INSERT INTO Pegi_Jeu VALUES(5,15);
INSERT INTO Pegi_Jeu VALUES(6,15);
INSERT INTO Pegi_Jeu VALUES(7,15);
INSERT INTO Pegi_Jeu VALUES(9,15);
INSERT INTO Pegi_Jeu VALUES(4,16);
INSERT INTO Pegi_Jeu VALUES(6,16);
INSERT INTO Pegi_Jeu VALUES(5,17);
INSERT INTO Pegi_Jeu VALUES(6,17);
INSERT INTO Pegi_Jeu VALUES(7,17);
INSERT INTO Pegi_Jeu VALUES(9,17);
INSERT INTO Pegi_Jeu VALUES(1,18);
INSERT INTO Pegi_Jeu VALUES(1,19);
INSERT INTO Pegi_Jeu VALUES(4,20);
INSERT INTO Pegi_Jeu VALUES(6,20);
INSERT INTO Pegi_Jeu VALUES(3,21);
INSERT INTO Pegi_Jeu VALUES(6,21);
INSERT INTO Pegi_Jeu VALUES(5,22);
INSERT INTO Pegi_Jeu VALUES(6,22);
INSERT INTO Pegi_Jeu VALUES(7,22);
INSERT INTO Pegi_Jeu VALUES(4,23);
INSERT INTO Pegi_Jeu VALUES(6,23);
INSERT INTO Pegi_Jeu VALUES(1,24);
INSERT INTO Pegi_Jeu VALUES(5,25);
INSERT INTO Pegi_Jeu VALUES(6,25);
INSERT INTO Pegi_Jeu VALUES(7,25);
INSERT INTO Pegi_Jeu VALUES(5,26);
INSERT INTO Pegi_Jeu VALUES(6,26);
INSERT INTO Pegi_Jeu VALUES(7,26);
INSERT INTO Pegi_Jeu VALUES(2,27);
INSERT INTO Pegi_Jeu VALUES(6,27);
INSERT INTO Pegi_Jeu VALUES(2,28);
INSERT INTO Pegi_Jeu VALUES(6,28);
INSERT INTO Pegi_Jeu VALUES(8,28);
INSERT INTO Pegi_Jeu VALUES(2,29);
INSERT INTO Pegi_Jeu VALUES(6,29);
INSERT INTO Pegi_Jeu VALUES(2,30);
INSERT INTO Pegi_Jeu VALUES(6,30);
INSERT INTO Pegi_Jeu VALUES(1,31);
INSERT INTO Pegi_Jeu VALUES(1,32);
INSERT INTO Pegi_Jeu VALUES(3,33);
INSERT INTO Pegi_Jeu VALUES(6,33);
INSERT INTO Pegi_Jeu VALUES(2,34);
INSERT INTO Pegi_Jeu VALUES(6,34);
INSERT INTO Pegi_Jeu VALUES(8,34);
INSERT INTO Pegi_Jeu VALUES(3,35);
INSERT INTO Pegi_Jeu VALUES(6,35);
INSERT INTO Pegi_Jeu VALUES(1,36);
INSERT INTO Pegi_Jeu VALUES(5,37);
INSERT INTO Pegi_Jeu VALUES(6,37);
INSERT INTO Pegi_Jeu VALUES(7,37);
INSERT INTO Pegi_Jeu VALUES(1,38);
INSERT INTO Pegi_Jeu VALUES(5,39);
INSERT INTO Pegi_Jeu VALUES(6,39);
INSERT INTO Pegi_Jeu VALUES(7,39);
INSERT INTO Pegi_Jeu VALUES(5,40);
INSERT INTO Pegi_Jeu VALUES(6,40);
INSERT INTO Pegi_Jeu VALUES(7,40);
INSERT INTO Pegi_Jeu VALUES(5,41);
INSERT INTO Pegi_Jeu VALUES(6,41);
INSERT INTO Pegi_Jeu VALUES(7,41);
INSERT INTO Pegi_Jeu VALUES(9,41);
INSERT INTO Pegi_Jeu VALUES(5,42);
INSERT INTO Pegi_Jeu VALUES(6,42);
INSERT INTO Pegi_Jeu VALUES(7,42);
INSERT INTO Pegi_Jeu VALUES(5,43);
INSERT INTO Pegi_Jeu VALUES(6,43);
INSERT INTO Pegi_Jeu VALUES(7,43);
INSERT INTO Pegi_Jeu VALUES(3,44);
INSERT INTO Pegi_Jeu VALUES(6,44);

INSERT INTO Genre_Jeu VALUES(11,1);
INSERT INTO Genre_Jeu VALUES(12,2);
INSERT INTO Genre_Jeu VALUES(10,3);
INSERT INTO Genre_Jeu VALUES(3,4);
INSERT INTO Genre_Jeu VALUES(8,4);
INSERT INTO Genre_Jeu VALUES(1,5);
INSERT INTO Genre_Jeu VALUES(13,6);
INSERT INTO Genre_Jeu VALUES(14,6);
INSERT INTO Genre_Jeu VALUES(1,7);
INSERT INTO Genre_Jeu VALUES(12,7);
INSERT INTO Genre_Jeu VALUES(3,8);
INSERT INTO Genre_Jeu VALUES(12,8);
INSERT INTO Genre_Jeu VALUES(13,8);
INSERT INTO Genre_Jeu VALUES(15,9);
INSERT INTO Genre_Jeu VALUES(8,10);
INSERT INTO Genre_Jeu VALUES(12,10);
INSERT INTO Genre_Jeu VALUES(10,11);
INSERT INTO Genre_Jeu VALUES(7,12);
INSERT INTO Genre_Jeu VALUES(1,13);
INSERT INTO Genre_Jeu VALUES(12,13);
INSERT INTO Genre_Jeu VALUES(13,13);
INSERT INTO Genre_Jeu VALUES(16,14);
INSERT INTO Genre_Jeu VALUES(11,15);
INSERT INTO Genre_Jeu VALUES(1,16);
INSERT INTO Genre_Jeu VALUES(3,2);
INSERT INTO Genre_Jeu VALUES(8,2);
INSERT INTO Genre_Jeu VALUES(10,17);
INSERT INTO Genre_Jeu VALUES(10,18);
INSERT INTO Genre_Jeu VALUES(2,20);
INSERT INTO Genre_Jeu VALUES(17,21);
INSERT INTO Genre_Jeu VALUES(3,22);
INSERT INTO Genre_Jeu VALUES(3,23);
INSERT INTO Genre_Jeu VALUES(9,24);
INSERT INTO Genre_Jeu VALUES(2,24);
INSERT INTO Genre_Jeu VALUES(3,25);
INSERT INTO Genre_Jeu VALUES(11,25);
INSERT INTO Genre_Jeu VALUES(12,25);
INSERT INTO Genre_Jeu VALUES(3,26);
INSERT INTO Genre_Jeu VALUES(12,26);
INSERT INTO Genre_Jeu VALUES(15,27);
INSERT INTO Genre_Jeu VALUES(1,28);
INSERT INTO Genre_Jeu VALUES(12,28);
INSERT INTO Genre_Jeu VALUES(10,29);
INSERT INTO Genre_Jeu VALUES(15,30);
INSERT INTO Genre_Jeu VALUES(15,31);
INSERT INTO Genre_Jeu VALUES(18,32);
INSERT INTO Genre_Jeu VALUES(16,33);
INSERT INTO Genre_Jeu VALUES(13,34);
INSERT INTO Genre_Jeu VALUES(14,34);
INSERT INTO Genre_Jeu VALUES(1,35);
INSERT INTO Genre_Jeu VALUES(8,35);
INSERT INTO Genre_Jeu VALUES(12,35);
INSERT INTO Genre_Jeu VALUES(9,36);
INSERT INTO Genre_Jeu VALUES(3,37);
INSERT INTO Genre_Jeu VALUES(11,37);
INSERT INTO Genre_Jeu VALUES(12,37);
INSERT INTO Genre_Jeu VALUES(9,38);
INSERT INTO Genre_Jeu VALUES(3,39);
INSERT INTO Genre_Jeu VALUES(15,40);
INSERT INTO Genre_Jeu VALUES(3,41);
INSERT INTO Genre_Jeu VALUES(8,41);
INSERT INTO Genre_Jeu VALUES(3,42);
INSERT INTO Genre_Jeu VALUES(3,43);
INSERT INTO Genre_Jeu VALUES(8,43);
INSERT INTO Genre_Jeu VALUES(3,44);
INSERT INTO Genre_Jeu VALUES(5,44);
INSERT INTO Genre_Jeu VALUES(12,44);

INSERT INTO Stock VALUES(1,1, 21.33, 4);
INSERT INTO Stock VALUES(2,1, 47.00, 5);
INSERT INTO Stock VALUES(3,1, 23.90, 4);
INSERT INTO Stock VALUES(4,1, 29.01, 3);
INSERT INTO Stock VALUES(5,1, 54.81, 3);
INSERT INTO Stock VALUES(6,1, 22.49, 5);
INSERT INTO Stock VALUES(7,1, 19.48, 1);
INSERT INTO Stock VALUES(8,1, 25.81, 2);
INSERT INTO Stock VALUES(9,1, 14.99, 3);
INSERT INTO Stock VALUES(10,1, 27.50, 4);
INSERT INTO Stock VALUES(11,1, 38.34, 0);
INSERT INTO Stock VALUES(12,1, 22.99, 1);
INSERT INTO Stock VALUES(13,1, 30.40, 2);
INSERT INTO Stock VALUES(14,1, 39.05, 5);
INSERT INTO Stock VALUES(15,2, 21.33, 4);
INSERT INTO Stock VALUES(16,2, 54.99, 1);
INSERT INTO Stock VALUES(17,2, 28.31, 2);
INSERT INTO Stock VALUES(18,2, 41.99, 3);
INSERT INTO Stock VALUES(19,2, 23.90, 1);
INSERT INTO Stock VALUES(20,2, 54.99, 0);
INSERT INTO Stock VALUES(21,2, 39.99, 5);
INSERT INTO Stock VALUES(22,2, 56.69, 1);
INSERT INTO Stock VALUES(23,2, 18.90, 3);
INSERT INTO Stock VALUES(24,2, 39.95, 2);
INSERT INTO Stock VALUES(25,2, 19.43, 0);
INSERT INTO Stock VALUES(26,2, 32.49, 5);
INSERT INTO Stock VALUES(27,3, 44.49, 2);
INSERT INTO Stock VALUES(28,3, 44.49, 4);
INSERT INTO Stock VALUES(29,3, 44.49, 0);
INSERT INTO Stock VALUES(30,3, 44.49, 1);
INSERT INTO Stock VALUES(31,3, 19.99, 4);
INSERT INTO Stock VALUES(32,3, 44.49, 5);
INSERT INTO Stock VALUES(33,3, 18.95, 3);
INSERT INTO Stock VALUES(34,3, 22.49, 4);
INSERT INTO Stock VALUES(35,3, 49.09, 2);
INSERT INTO Stock VALUES(36,3, 44.99, 2);
INSERT INTO Stock VALUES(37,4, 14.99, 5);
INSERT INTO Stock VALUES(38,4, 18.99, 1);
INSERT INTO Stock VALUES(39,4, 26.19, 4);
INSERT INTO Stock VALUES(40,1, 24.99, 1);
INSERT INTO Stock VALUES(41,4, 39.99, 5);
INSERT INTO Stock VALUES(42,4, 22.34, 3);
INSERT INTO Stock VALUES(43,4, 5.39, 1);
INSERT INTO Stock VALUES(44,4, 25.68, 0);

/*----- Functions and trigger ------*/

CREATE OR REPLACE FUNCTION remove_stock()
RETURNS TRIGGER AS
$$
    DECLARE
    begin
      UPDATE stock SET quantite = quantite-1
      WHERE id_jeu = new.id_produit;
      RETURN new;
    end;
$$
LANGUAGE 'plpgsql';

CREATE TRIGGER remove_stock
AFTER INSERT
ON Reservation
FOR EACH ROW
EXECUTE PROCEDURE remove_stock();


CREATE OR REPLACE FUNCTION public."searchGame"(p_query text,p_id_plateforme integer)
   RETURNS SETOF jeu_details
AS $$
BEGIN
   RETURN QUERY SELECT * 
    FROM jeu_details
    WHERE nom LIKE p_query ESCAPE '!'
    AND id_plateforme = p_id_plateforme;
END; $$ 
 
LANGUAGE 'plpgsql';


CREATE OR REPLACE FUNCTION public."reservationUtilisateur"(p_login_utilisateur text)
   RETURNS SETOF jeu_details
AS $$
BEGIN
   RETURN QUERY SELECT * 
    FROM jeu_details
    WHERE jeu_details.id_jeu IN (SELECT id_produit FROM reservation WHERE login_utilisateur = p_login_utilisateur);
END; $$ 
 
LANGUAGE 'plpgsql';


CREATE OR REPLACE FUNCTION public."topReservation"()
   RETURNS SETOF jeu_details
AS $$
BEGIN
	RETURN QUERY SELECT * 
	FROM jeu_details
	WHERE id_jeu IN(
	SELECT id_produit
		FROM reservation
		GROUP BY id_produit
		LIMIT 5);
END; $$ 
LANGUAGE 'plpgsql';


CREATE OR REPLACE FUNCTION public."countReservation"(p_login_utilisateur text)
   RETURNS TABLE(id_jeu INTEGER, quantite BIGINT)
AS $$
BEGIN
   RETURN QUERY SELECT id_produit, count(id_produit) 
   FROM reservation 
   WHERE login_utilisateur = p_login_utilisateur
   GROUP by id_produit;
END; $$ 
 
LANGUAGE 'plpgsql';

