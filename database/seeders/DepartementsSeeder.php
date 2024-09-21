<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departements = [
            ["nom" => "Dakar", "region" => "Dakar", "arrondissements" => json_encode(["Almadies", "Dakar Plateau", "Grand Dakar", "Parcelles Assainies"])],
            ["nom" => "Guédiawaye", "region" => "Dakar", "arrondissements" => json_encode(["Golf Sud", "Médina Gounass", "Ndiarème Limamoulaye", "Sam Notaire", "Wakhinane Nimzatt"])],
            ["nom" => "Keur Massar", "region" => "Dakar", "arrondissements" => json_encode(["Yeumbeul Nord", "Yeumbeul Sud", "Malika", "Keur Massar Nord", "Keur Massar Sud", "Jaxaay-Parcelles"])],
            ["nom" => "Pikine", "region" => "Dakar", "arrondissements" => json_encode(["Dagoudane", "Thiaroye"])],
            ["nom" => "Rufisque", "region" => "Dakar", "arrondissements" => json_encode(["Rufisque", "Sangalkam", "Bambylor"])],
            ["nom" => "Bambey", "region" => "Diourbel", "arrondissements" => json_encode(["Baba Garage", "Lambaye", "Ngoye"])],
            ["nom" => "Diourbel", "region" => "Diourbel", "arrondissements" => json_encode(["Ndindy", "Ndoulo"])],
            ["nom" => "Mbacké", "region" => "Diourbel", "arrondissements" => json_encode(["Kael", "Ndame", "Taïf"])],
            ["nom" => "Fatick", "region" => "Fatick", "arrondissements" => json_encode(["Diakhao", "Fimela", "Niakhar", "Tattaguine"])],
            ["nom" => "Foundiougne", "region" => "Fatick", "arrondissements" => json_encode(["Djilor", "Niodior", "Toubacouta"])],
            ["nom" => "Gossas", "region" => "Fatick", "arrondissements" => json_encode(["Colobane", "Ouadiour"])],
            ["nom" => "Birkelane", "region" => "Kaffrine", "arrondissements" => json_encode(["Keur Mboucki", "Mabo"])],
            ["nom" => "Kaffrine", "region" => "Kaffrine", "arrondissements" => json_encode(["Gniby", "Katakel"])],
            ["nom" => "Koungheul", "region" => "Kaffrine", "arrondissements" => json_encode(["Missirah Wadene", "Ida Mouride", "Lour Escale"])],
            ["nom" => "Malème-Hodar", "region" => "Kaffrine", "arrondissements" => json_encode(["Darou Minam 2", "Sagna"])],
            ["nom" => "Guinguinéo", "region" => "Kaolack", "arrondissements" => json_encode(["Mbadakhoune", "Nguélou"])],
            ["nom" => "Kaolack", "region" => "Kaolack", "arrondissements" => json_encode(["Koumbal", "Ndiédieng", "Sibassor"])],
            ["nom" => "Nioro du Rip", "region" => "Kaolack", "arrondissements" => json_encode(["Wack Ngouna", "Médina Sabakh", "Paoskoto"])],
            ["nom" => "Kédougou", "region" => "Kédougou", "arrondissements" => json_encode(["Bandafassi", "Fongolembi"])],
            ["nom" => "Salemata", "region" => "Kédougou", "arrondissements" => json_encode(["Dakateli", "Dar Salam"])],
            ["nom" => "Saraya", "region" => "Kédougou", "arrondissements" => json_encode(["Bembou", "Sabodala"])],
            ["nom" => "Kolda", "region" => "Kolda", "arrondissements" => json_encode(["Djoulacolon", "Mampatim", "Saré Bidji"])],
            ["nom" => "Vélingara", "region" => "Kolda", "arrondissements" => json_encode(["Bonconto", "Pakour", "Saré Coly Sallé"])],
            ["nom" => "Médina Yoro Foulah", "region" => "Kolda", "arrondissements" => json_encode(["Fafacourou", "Ndorna", "Niaming"])],
            ["nom" => "Kébémer", "region" => "Louga", "arrondissements" => json_encode(["Darou Mousty", "Ndande", "Sagatta Gueth"])],
            ["nom" => "Linguère", "region" => "Louga", "arrondissements" => json_encode(["Barkédji", "Dodji", "Sagatta", "Dioloff", "Yang-Yang"])],
            ["nom" => "Louga", "region" => "Louga", "arrondissements" => json_encode(["Coki", "Mbédiène", "Sakal", "Keur Momar Sarr"])],
            ["nom" => "Kanel", "region" => "Matam", "arrondissements" => json_encode(["Orkadiere", "Wouro Sidy"])],
            ["nom" => "Matam", "region" => "Matam", "arrondissements" => json_encode(["Agnam Civol", "Ogo"])],
            ["nom" => "Ranérou-Ferlo", "region" => "Matam", "arrondissements" => json_encode(["Orkadiere", "Wouro Sidy"])],
            ["nom" => "Dagana", "region" => "Saint-Louis", "arrondissements" => json_encode(["Mbane", "Ndiaye"])],
            ["nom" => "Podor", "region" => "Saint-Louis", "arrondissements" => json_encode(["Cas-Cas", "Gamadji Saré", "Saldé", "Thillé Boubacar"])],
            ["nom" => "Saint-Louis", "region" => "Saint-Louis", "arrondissements" => json_encode(["Rao"])],
            ["nom" => "Bounkiling", "region" => "Sédhiou", "arrondissements" => json_encode(["Boghal", "Bona", "Diaroumé"])],
            ["nom" => "Goudomp", "region" => "Sédhiou", "arrondissements" => json_encode(["Djibanar", "Simbandi Brassou", "Karantaba"])],
            ["nom" => "Sédhiou", "region" => "Sédhiou", "arrondissements" => json_encode(["Diendé", "Djibabouya", "Djiredji"])],
            ["nom" => "Bakel", "region" => "Tambacounda", "arrondissements" => json_encode(["Bélé", "Kéniaba", "Moudéry"])],
            ["nom" => "Goudiry", "region" => "Tambacounda", "arrondissements" => json_encode(["Bala", "Boynguel Bamba", "Dianké Makha", "Koulor"])],
            ["nom" => "Koumpentoum", "region" => "Tambacounda", "arrondissements" => json_encode(["Bamba Thialène", "Kouthiaba Wolof"])],
            ["nom" => "Tambacounda", "region" => "Tambacounda", "arrondissements" => json_encode(["Koussanar", "Makacolibantang", "Missirah"])],
            ["nom" => "Mbour", "region" => "Thies", "arrondissements" => json_encode(["Fissel", "Sindia", "Séssène"])],
            ["nom" => "Thies", "region" => "Thies", "arrondissements" => json_encode(["Keur Moussa", "Notto", "Thiénaba", "Thies Nord", "Thies Sud"])],
            ["nom" => "Tivaouane", "region" => "Thies", "arrondissements" => json_encode(["Mérina Dakhar", "Méouane", "Niakhène", "Pambal"])],
            ["nom" => "Kaffrine", "region" => "Kaffrine", "arrondissements" => json_encode(["Mélina", "Mbacké", "Nioro du Rip"])],
        ];

        DB::table('departements')->insert($departements);
    }
}
