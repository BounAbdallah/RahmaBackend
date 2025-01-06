<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemovePermissionsFromDatabase extends Migration
{
    public function up()
    {
        // Supprimer toutes les permissions
        DB::table('permissions')->delete();

        // Supprimer toutes les relations permissions-rôles
        DB::table('role_has_permissions')->delete();
    }

    public function down()
    {
        // Pas besoin d'implémenter le rollback, car les permissions ne seront plus utilisées
    }
}
