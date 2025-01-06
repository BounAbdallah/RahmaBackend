<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('nationalite', [
                'Afghan', 'Albanais', 'Algérien', 'Allemand', 'Américain', 'Andorran', 'Angolais',
                'Antiguais', 'Argentin', 'Arménien', 'Australien', 'Autrichien', 'Azerbaïdjanais',
                'Bahaméen', 'Bahreïnien', 'Bangladais', 'Barbadien', 'Belge', 'Bélizien', 'Béninois',
                'Bhoutanais', 'Biélorusse', 'Birman', 'Bolivien', 'Bosnien', 'Botswanais', 'Brésilien',
                'Britannique', 'Brunéien', 'Bulgare', 'Burkinabé', 'Burundais', 'Cambodgien', 'Camerounais',
                'Canadien', 'Capverdien', 'Centrafricain', 'Chilien', 'Chinois', 'Chypriote', 'Colombien',
                'Comorien', 'Congolais', 'Costaricien', 'Croate', 'Cubain', 'Danois', 'Djiboutien',
                'Dominicain', 'Égyptien', 'Émirati', 'Équatorien', 'Érythréen', 'Espagnol', 'Estonien',
                'Éthiopien', 'Fidjien', 'Finlandais', 'Français', 'Gabonnais', 'Gambien', 'Géorgien',
                'Ghanéen', 'Grec', 'Grenadien', 'Guatémaltèque', 'Guinéen', 'Guinéen équatorial',
                'Guyanien', 'Haïtien', 'Hondurien', 'Hongrois', 'Indien', 'Indonésien', 'Irakien',
                'Irlandais', 'Islandais', 'Israélien', 'Italien', 'Ivoirien', 'Jamaïcain', 'Japonais',
                'Jordanien', 'Kazakh', 'Kenyan', 'Kirghiz', 'Kiribatien', 'Koweïtien', 'Laotien',
                'Letton', 'Libanais', 'Libérien', 'Libyen', 'Liechtensteinois', 'Lituanien', 'Luxembourgeois',
                'Macédonien', 'Malaisien', 'Malawien', 'Maldivien', 'Malien', 'Maltais', 'Maréchalais',
                'Marocain', 'Mauricien', 'Mauritanien', 'Mexicain', 'Micronésien', 'Moldave', 'Monégasque',
                'Mongol', 'Monténégrin', 'Mozambicain', 'Namibien', 'Nauruan', 'Néerlandais', 'Néo-Zélandais',
                'Népalais', 'Nicaraguayen', 'Nigerian', 'Nigérien', 'Nord-Coréen', 'Norvégien', 'Omanais',
                'Ougandais', 'Ouzbek', 'Pakistanais', 'Palestinien', 'Panaméen', 'Papou-néo-guinéen',
                'Paraguayen', 'Péruvien', 'Philippin', 'Polonais', 'Portoricain', 'Portugais', 'Qatari',
                'Roumain', 'Russe', 'Rwandais', 'Saint-Lucien', 'Saint-Marinais', 'Salomonien', 'Salvadorien',
                'Samoan', 'Sao-Toméen', 'Sénégalais', 'Serbe', 'Seychellois', 'Sierra-Léonais', 'Singapourien',
                'Slovaque', 'Slovène', 'Somalien', 'Soudanais', 'Sri-Lankais', 'Sud-Africain', 'Sud-Coréen',
                'Sud-Soudanais', 'Suédois', 'Suisse', 'Surinamien', 'Swazi', 'Syrien', 'Tadjik', 'Tanzanien',
                'Tchadien', 'Tchèque', 'Thaïlandais', 'Timorais', 'Togolais', 'Tongien', 'Trinidadien',
                'Tunisien', 'Turkmène', 'Turc', 'Tuvaluan', 'Ukrainien', 'Uruguayen', 'Vanuatuan',
                'Vénézuélien', 'Vietnamien', 'Yéménite', 'Zambien', 'Zimbabwéen'
            ])->default('Sénégalais'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nationalite'); // Supprimer le champ nationalité
        });
    }
};
