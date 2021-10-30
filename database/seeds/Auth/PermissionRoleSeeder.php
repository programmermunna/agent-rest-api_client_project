<?php

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        // Role::create([
        //     'id' => 1,
        //     'type' => User::TYPE_ADMIN,
        //     'name' => 'Administrator',
        // ]);

        Role::create([
            'id' => '2',
            'type' => 'user',
            'name' => 'Administrator',
            'guard_name' => 'web',
            'created_at' => '2021-09-04 09:43:28',
            'updated_at' => '2021-09-13 09:17:50'
        ]);
        
        // Table permissions
        Permission::create([
            'id' => '1',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.user',
            'description' => 'Can Access Admin Users',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-14 08:14:37',
            'updated_at' => '2021-09-14 08:14:37'
        ]);
        Permission::create([
            'id' => '3',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.user.deactivate',
            'description' => 'Can Access Deactivate Admin Users',
            'parent_id' => NULL,'sort' => '2',
            'created_at' => '2020-10-02 18:07:23',
            'updated_at' => '2021-09-14 02:55:33'
        ]);
        Permission::create([
            'id' => '4',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.user.reactivate',
            'description' => 'Can Access Reactivate Admin Users',
            'parent_id' => NULL,'sort' => '3',
            'created_at' => '2020-10-02 18:07:23',
            'updated_at' => '2021-09-14 02:55:39'
        ]);
        Permission::create([
            'id' => '5',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.user.clear-session',
            'description' => 'Can Access Clear Admin User Sessions',
            'parent_id' => NULL,'sort' => '4',
            'created_at' => '2020-10-02 18:07:23',
            'updated_at' => '2021-09-14 02:55:45'
        ]);
        Permission::create([
            'id' => '6',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.user.impersonate',
            'description' => 'Can Access Impersonate Users',
            'parent_id' => NULL,'sort' => '5',
            'created_at' => '2020-10-02 18:07:23',
            'updated_at' => '2021-09-14 08:19:06'
        ]);
        Permission::create([
            'id' => '7',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.user.change-password',
            'description' => 'Can Access Change User Passwords',
            'parent_id' => NULL,'sort' => '6',
            'created_at' => '2020-10-02 18:07:23',
            'updated_at' => '2021-09-14 02:55:55'
        ]);
        Permission::create([
            'id' => '17',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.log',
            'description' => 'Can Access Members Log',
            'parent_id' => NULL,'sort' => '0',
            'created_at' => '2020-11-12 15:19:23',
            'updated_at' => '2021-09-13 23:38:49'
        ]);
        Permission::create([
            'id' => '28',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.ip',
            'description' => 'Can Access Admin IP',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 04:39:35',
            'updated_at' => '2021-09-13 12:03:08'
        ]);
        Permission::create([
            'id' => '29',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.log',
            'description' => 'Can Access Admin Log',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 04:40:05',
            'updated_at' => '2021-09-13 12:03:12'
        ]);
        Permission::create([
            'id' => '30',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.all_members',
            'description' => 'Can Access All members',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 04:40:39',
            'updated_at' => '2021-09-13 12:03:41'
        ]);
        Permission::create([
            'id' => '31',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.win_lose_all',
            'description' => 'Can Access All Win Lose',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 04:41:53',
            'updated_at' => '2021-09-13 12:03:54'
        ]);
        Permission::create([
            'id' => '32',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.daily_referal',
            'description' => 'Can Access All Daily Refferal',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 04:42:32',
            'updated_at' => '2021-09-16 08:34:32'
        ]);
        Permission::create([
            'id' => '33',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.deposit',
            'description' => 'Can Access All Deposit',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 10:03:16',
            'updated_at' => '2021-09-13 23:07:38'
        ]);
        Permission::create([
            'id' => '34',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.deposit.approveDepo',
            'description' => 'Can Access Deposit Approval',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 10:04:33',
            'updated_at' => '2021-09-14 04:33:00'
        ]);
        Permission::create([
            'id' => '35',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.all_members.editProfile',
            'description' => 'Can Edit Members Profile',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:08:22',
            'updated_at' => '2021-09-13 23:08:22'
        ]);
        Permission::create([
            'id' => '36',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.all_members.editRekening',
            'description' => 'Can Edit Members Rekening',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:13:58',
            'updated_at' => '2021-09-13 23:13:58'
        ]);
        Permission::create([
            'id' => '37',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.lain_lain.broadcast',
            'description' => 'Can See all Broadcast ',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:38:28',
            'updated_at' => '2021-09-13 23:38:28'
        ]);
        Permission::create([
            'id' => '38',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.lain_lain.broadcast.create',
            'description' => 'Can Create Broadcast',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:42:37',
            'updated_at' => '2021-09-13 23:42:37'
        ]);
        Permission::create([
            'id' => '39',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.lain_lain.broadcast.update',
            'description' => 'Can Update Broadcast',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:43:01',
            'updated_at' => '2021-09-13 23:43:01'
        ]);
        Permission::create([
            'id' => '40',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.lain_lain.broadcast.set_enable',
            'description' => 'Can Enable Broadcast',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:43:39',
            'updated_at' => '2021-09-13 23:43:39'
        ]);
        Permission::create([
            'id' => '41',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.lain_lain.broadcast.delete',
            'description' => 'Can Delete Broadcast',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:44:19',
            'updated_at' => '2021-09-13 23:44:19'
        ]);
        Permission::create([
            'id' => '42',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.all_members.updatePassword',
            'description' => 'Can Update Members Password',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:45:59',
            'updated_at' => '2021-09-13 23:45:59'
        ]);
        Permission::create([
            'id' => '43',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.all_members.updateMember',
            'description' => 'Can Update Members',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:47:06',
            'updated_at' => '2021-09-13 23:47:06'
        ]);
        Permission::create([
            'id' => '44',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.all_members.depoWdForm',
            'description' => 'Can Perform Withdrawal And Deposit',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:49:05',
            'updated_at' => '2021-09-13 23:49:05'
        ]);
        Permission::create([
            'id' => '45',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.all_members.editReferral',
            'description' => 'Can Edit Referrals',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:49:41',
            'updated_at' => '2021-09-13 23:49:41'
        ]);
        Permission::create([
            'id' => '46',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.all_members.editHistory',
            'description' => 'Can Edit Histories',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:50:22',
            'updated_at' => '2021-09-13 23:50:22'
        ]);
        Permission::create([
            'id' => '47',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.all_members.editCredit',
            'description' => 'Can Edit Credit',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:51:08',
            'updated_at' => '2021-09-13 23:51:08'
        ]);
        Permission::create([
            'id' => '48',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.memo',
            'description' => 'See All Memo',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:52:28',
            'updated_at' => '2021-09-13 23:52:28'
        ]);
        Permission::create([
            'id' => '49',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.memo.create',
            'description' => 'Can Create Memo',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:52:55',
            'updated_at' => '2021-09-13 23:52:55'
        ]);
        Permission::create([
            'id' => '50',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.memo.editMemo',
            'description' => 'Can Edit Memo',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-13 23:53:28',
            'updated_at' => '2021-09-13 23:53:28'
        ]);
        Permission::create([
            'id' => '52',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.level',
            'description' => 'Can Access Admin Level',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-14 04:40:36',
            'updated_at' => '2021-09-14 04:40:36'
        ]);
        Permission::create([
            'id' => '53',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.level.create',
            'description' => 'Can Access Create Admin Level',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-14 05:23:36',
            'updated_at' => '2021-09-14 05:23:36'
        ]);
        Permission::create([
            'id' => '54',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.withdraw',
            'description' => 'Can Access All Withdraw',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-14 06:51:27',
            'updated_at' => '2021-09-14 06:51:27'
        ]);
        Permission::create([
            'id' => '56',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.user.create',
            'description' => 'Can Access Create Admin Users',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-14 08:20:32',
            'updated_at' => '2021-09-14 08:20:32'
        ]);
        Permission::create([
            'id' => '57',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.user.update',
            'description' => 'Can Access Update Admin Users',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-14 08:20:40',
            'updated_at' => '2021-09-14 08:20:40'
        ]);
        Permission::create([
            'id' => '58',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.user.delete',
            'description' => 'Can Access Delete Admin Users',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-14 08:20:51',
            'updated_at' => '2021-09-14 08:20:51'
        ]);
        Permission::create([
            'id' => '59',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.lain_lain.status',
            'description' => 'Can See all Status on Lain-Lain',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-14 08:34:43',
            'updated_at' => '2021-09-14 08:34:43'
        ]);
        Permission::create([
            'id' => '60',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.all_members.freebet',
            'description' => 'Can Access FreeBet Members',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 08:17:52',
            'updated_at' => '2021-09-16 08:17:52'
        ]);
        Permission::create([
            'id' => '61',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.user_referal',
            'description' => 'Can Access All User Refferal',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 08:36:02',
            'updated_at' => '2021-09-16 08:36:02'
        ]);
        Permission::create([
            'id' => '62',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.deposit.cancelDepo',
            'description' => 'Can Access Cancel Deposit',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 08:39:16',
            'updated_at' => '2021-09-16 08:39:16'
        ]);
        Permission::create([
            'id' => '63',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.deposit.updateDepo',
            'description' => 'Can Access Update Deposit',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 08:40:56',
            'updated_at' => '2021-09-16 08:40:56'
        ]);
        Permission::create([
            'id' => '64',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.deposit.delete',
            'description' => 'Can Access Delete Deposit',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 08:41:20',
            'updated_at' => '2021-09-16 08:41:20'
        ]);
        Permission::create([
            'id' => '65',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.withdraw.approveWd',
            'description' => 'Can Access Approve Withdraw',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 08:46:24',
            'updated_at' => '2021-09-16 08:46:24'
        ]);
        Permission::create([
            'id' => '66',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.withdraw.update',
            'description' => 'Can Access Update Withdraw',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 08:47:53',
            'updated_at' => '2021-09-16 08:47:53'
        ]);
        Permission::create([
            'id' => '67',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.withdraw.delete',
            'description' => 'Can Access Delete Withdraw',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 08:48:36',
            'updated_at' => '2021-09-16 08:48:36'
        ]);
        Permission::create([
            'id' => '68',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.withdraw.cancelData',
            'description' => 'Can Access Cancel Withdraw',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 08:49:54',
            'updated_at' => '2021-09-16 08:49:54'
        ]);
        Permission::create([
            'id' => '69',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.level.update',
            'description' => 'Can Access Update Admin Level',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 08:53:31',
            'updated_at' => '2021-09-16 08:53:31'
        ]);
        Permission::create([
            'id' => '70',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.level.delete',
            'description' => 'Can Access Delete Admin Level',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 08:54:12',
            'updated_at' => '2021-09-16 08:54:12'
        ]);
        Permission::create([
            'id' => '71',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.ip.enable',
            'description' => 'Can Access Enable Admin IP',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 09:06:08',
            'updated_at' => '2021-09-16 09:06:08'
        ]);
        Permission::create([
            'id' => '72',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.ip.create',
            'description' => 'Can Access Create Admin IP',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 09:07:56',
            'updated_at' => '2021-09-16 09:07:56'
        ]);
        Permission::create([
            'id' => '73',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.ip.updateIp',
            'description' => 'Can Access Update Admin IP',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 09:08:24',
            'updated_at' => '2021-09-16 09:08:24'
        ]);
        Permission::create([
            'id' => '74',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.admin.ip.deleteIp',
            'description' => 'Can Access Delete Admin IP',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 09:09:05',
            'updated_at' => '2021-09-16 09:09:05'
        ]);
        Permission::create([
            'id' => '75',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account',
            'description' => 'Can Access Rekening Agent Account ',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 09:19:36',
            'updated_at' => '2021-09-16 09:59:07'
        ]);
        Permission::create([
            'id' => '76',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.create',
            'description' => 'Can Access Create Rekening Agent Account ',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 09:27:49',
            'updated_at' => '2021-09-16 09:58:57'
        ]);
        Permission::create([
            'id' => '77',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.update',
            'description' => 'Can Access Update Rekening Agent Account ',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 09:49:32',
            'updated_at' => '2021-09-16 09:58:51'
        ]);
        Permission::create([
            'id' => '78',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.delete',
            'description' => 'Can Access Delete Rekening Agent Account ',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 09:50:46',
            'updated_at' => '2021-09-16 09:58:46'
        ]);
        Permission::create([
            'id' => '79',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.migrasi',
            'description' => 'Can Access Migrasi Rekening Agent Account ',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 09:53:47',
            'updated_at' => '2021-09-16 09:58:33'
        ]);
        Permission::create([
            'id' => '80',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.discountNonbank',
            'description' => 'Can Access Discount Non Bank Rekening Agent Account',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 09:54:59',
            'updated_at' => '2021-09-16 09:58:27'
        ]);
        Permission::create([
            'id' => '81',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.createDiscountNonbank',
            'description' => 'Can Access Create Discount Non Bank Rekening Agent Account',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 09:56:07',
            'updated_at' => '2021-09-16 10:02:11'
        ]);
        Permission::create([
            'id' => '82',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.enableDiscountNonbank',
            'description' => 'Can Access Enable Discount Non Bank Rekening Agent Account',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:03:01',
            'updated_at' => '2021-09-16 10:03:01'
        ]);
        Permission::create([
            'id' => '83',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.updateDiscountNonbank',
            'description' => 'Can Access Update Discount Non Bank Rekening Agent Account',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:03:33',
            'updated_at' => '2021-09-16 10:03:33'
        ]);
        Permission::create([
            'id' => '84',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.deleteDiscountNonbank',
            'description' => 'Can Access Delete Discount Non Bank Rekening Agent Account',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:05:30',
            'updated_at' => '2021-09-16 10:05:30'
        ]);
        Permission::create([
            'id' => '85',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.listBankName',
            'description' => 'Can Access List Bank Rekening Agent Account',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:07:09',
            'updated_at' => '2021-09-16 10:07:09'
        ]);
        Permission::create([
            'id' => '86',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.createBankName',
            'description' => 'Can Access Create Name Bank Rekening Agent Account',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:11:25',
            'updated_at' => '2021-09-16 10:11:25'
        ]);
        Permission::create([
            'id' => '87',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.updateBankName',
            'description' => 'Can Access Update Name Bank Rekening Agent Account',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:11:45',
            'updated_at' => '2021-09-16 10:11:45'
        ]);
        Permission::create([
            'id' => '88',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.deleteBankName',
            'description' => 'Can Access Delete Name Bank Rekening Agent Account',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:12:01',
            'updated_at' => '2021-09-16 10:12:01'
        ]);
        Permission::create([
            'id' => '89',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.account.manageUserRekening',
            'description' => 'Can Access Manage User Rekening Account',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:13:52',
            'updated_at' => '2021-09-16 10:13:52'
        ]);
        Permission::create([
            'id' => '907',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.mutasi',
            'description' => 'Can Access Mutasi Bank',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:34:01',
            'updated_at' => '2021-09-16 10:34:01'
        ]);
        Permission::create([
            'id' => '908',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.balance',
            'description' => 'Can Access Balance Bank',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:41:31',
            'updated_at' => '2021-09-16 10:41:31'
        ]);
        Permission::create([
            'id' => '909',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.balance.update',
            'description' => 'Can Access Update Balance Bank',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:43:35',
            'updated_at' => '2021-09-16 10:43:35'
        ]);
        Permission::create([
            'id' => '910',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.bank_status',
            'description' => 'Can Access Bank Online',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:44:33',
            'updated_at' => '2021-09-16 10:44:33'
        ]);
        Permission::create([
            'id' => '911',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.services.bank_status.update',
            'description' => 'Can Access Update Bank Online',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:45:10',
            'updated_at' => '2021-09-16 10:45:10'
        ]);
        Permission::create([
            'id' => '912',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.freeBet',
            'description' => 'Can Access FreeBet',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:47:30',
            'updated_at' => '2021-09-16 10:47:30'
        ]);
        Permission::create([
            'id' => '913',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.freeBet.create',
            'description' => 'Can Create FreeBet',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:50:37',
            'updated_at' => '2021-09-16 10:50:37'
        ]);
        Permission::create([
            'id' => '914',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.freeBet.enable',
            'description' => 'Can Enable FreeBet',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:50:56',
            'updated_at' => '2021-09-16 10:50:56'
        ]);
        Permission::create([
            'id' => '915',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.freeBet.update',
            'description' => 'Can Update FreeBet',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:51:12',
            'updated_at' => '2021-09-16 10:51:12'
        ]);
        Permission::create([
            'id' => '916',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.freeBet.delete',
            'description' => 'Can Delete FreeBet',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:51:30',
            'updated_at' => '2021-09-16 10:51:30'
        ]);
        Permission::create([
            'id' => '917',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.freeBet.view',
            'description' => 'Can View Detail FreeBet',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:51:50',
            'updated_at' => '2021-09-16 10:51:50'
        ]);
        Permission::create([
            'id' => '918',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.potonganProviderNonBank',
            'description' => 'Can Access Potongan Provider Non Bank',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 10:53:20',
            'updated_at' => '2021-09-16 10:53:20'
        ]);
        Permission::create([
            'id' => '919',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.bonusSetting',
            'description' => 'Can Access Bonus Setting',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:04:45',
            'updated_at' => '2021-09-16 11:04:45'
        ]);
        Permission::create([
            'id' => '920',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.bonusSetting.bonusTurnover',
            'description' => 'Can Access Bonus Setting > List Bonus Turnover',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:06:25',
            'updated_at' => '2021-09-16 11:07:16'
        ]);
        Permission::create([
            'id' => '921',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.bonusSetting.createBonusTurnover',
            'description' => 'Can Access Bonus Setting > Create Bonus Turnover',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:07:08',
            'updated_at' => '2021-09-16 11:07:08'
        ]);
        Permission::create([
            'id' => '922',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.bonusSetting.updateBonusTurnover',
            'description' => 'Can Access Bonus Setting > Update Bonus Turnover',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:07:37',
            'updated_at' => '2021-09-16 11:07:37'
        ]);
        Permission::create([
            'id' => '923',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.bonusSetting.deleteBonusTurnover',
            'description' => 'Can Access Bonus Setting > Delete Bonus Turnover',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:07:53',
            'updated_at' => '2021-09-16 11:07:53'
        ]);
        Permission::create([
            'id' => '924',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.bonusSetting.bonusCashback',
            'description' => 'Can Access Bonus Setting > List Bonus Cashback',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:08:20',
            'updated_at' => '2021-09-16 11:08:20'
        ]);
        Permission::create([
            'id' => '925',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.bonusSetting.createBonusCashback',
            'description' => 'Can Access Bonus Setting > Create Bonus Cashback',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:09:03',
            'updated_at' => '2021-09-16 11:10:49'
        ]);
        Permission::create([
            'id' => '926',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.bonusSetting.updateBonusCashback',
            'description' => 'Can Access Bonus Setting > Update Bonus Cashback',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:09:28',
            'updated_at' => '2021-09-16 11:10:55'
        ]);
        Permission::create([
            'id' => '927',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.bonusSetting.deleteBonusCashback',
            'description' => 'Can Access Bonus Setting > Delete Bonus Cashback',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:09:47',
            'updated_at' => '2021-09-16 11:11:01'
        ]);
        Permission::create([
            'id' => '928',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.bonusSetting.bonusReferral',
            'description' => 'Can Access Bonus Setting > List Bonus Referral',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:10:20',
            'updated_at' => '2021-09-16 11:10:20'
        ]);
        Permission::create([
            'id' => '929',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.bonusSetting.updateBonusReferral',
            'description' => 'Can Access Bonus Setting > Update Bonus Referral',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:11:36',
            'updated_at' => '2021-09-16 11:11:36'
        ]);
        Permission::create([
            'id' => '930',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.setting.maintenance',
            'description' => 'Can Access Maintenance',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:20:02',
            'updated_at' => '2021-09-16 11:20:02'
        ]);
        Permission::create([
            'id' => '931',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.setting.web',
            'description' => 'Can Access Web',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:34:01',
            'updated_at' => '2021-09-16 11:34:01'
        ]);
        Permission::create([
            'id' => '932',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.setting.web.sosMed',
            'description' => 'Can Access SosMed',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:34:13',
            'updated_at' => '2021-09-16 11:34:13'
        ]);
        Permission::create([
            'id' => '933',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.cms.website_content',
            'description' => 'Can Access Website Content',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:36:55',
            'updated_at' => '2021-09-16 11:36:55'
        ]);
        Permission::create([
            'id' => '934',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.cms.slide_and_popup_images',
            'description' => 'Can Access Slide & Pop Up Images',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:39:43',
            'updated_at' => '2021-09-16 11:39:43'
        ]);
        Permission::create([
            'id' => '935',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.cms.website_content.update',
            'description' => 'Can Access Update Website Content',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:40:42',
            'updated_at' => '2021-09-16 11:40:42'
        ]);
        Permission::create([
            'id' => '936',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.cms.slide_and_popup_images.uploudImage',
            'description' => 'Can Uploud image Slide & Pop Up Images',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:55:38',
            'updated_at' => '2021-09-16 11:55:38'
        ]);
        Permission::create([
            'id' => '937',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.cms.slide_and_popup_images.create',
            'description' => 'Can Create New Slide',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:55:52',
            'updated_at' => '2021-09-16 11:55:52'
        ]);
        Permission::create([
            'id' => '938',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.cms.slide_and_popup_images.update',
            'description' => 'Can Update Slide & Pop Up Images',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:56:05',
            'updated_at' => '2021-09-16 11:56:05'
        ]);
        Permission::create([
            'id' => '939',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.cms.slide_and_popup_images.set_enabled',
            'description' => 'Can Set Enable Slide & Pop Up Images',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:56:19',
            'updated_at' => '2021-09-16 11:56:19'
        ]);
        Permission::create([
            'id' => '940',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.cms.slide_and_popup_images.delete',
            'description' => 'Can Delete Slide',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:56:33',
            'updated_at' => '2021-09-16 11:56:33'
        ]);
        Permission::create([
            'id' => '941',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.cms.slide_and_popup_images.slide_up',
            'description' => 'Can Slide Up Slide',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:56:44',
            'updated_at' => '2021-09-16 11:56:44'
        ]);
        Permission::create([
            'id' => '942',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.cms.promo_page',
            'description' => 'Can Access Promo Page',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:58:39',
            'updated_at' => '2021-09-16 11:58:39'
        ]);
        Permission::create([
            'id' => '943',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bonus.bonusHistory',
            'description' => 'Can Access Bonus History',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:58:39',
            'updated_at' => '2021-09-16 11:58:39'
        ]);
        Permission::create([
            'id' => '944',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.setting.games',
            'description' => 'Can Access Setting Games',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:58:39',
            'updated_at' => '2021-09-16 11:58:39'
        ]);
        Permission::create([
            'id' => '945',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.keluaran.list-keluaran',
            'description' => 'Can Access List Keluaran',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:58:39',
            'updated_at' => '2021-09-16 11:58:39'
        ]);
        Permission::create([
            'id' => '946',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bet.list-bets',
            'description' => 'Can Access List Bet',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:58:39',
            'updated_at' => '2021-09-16 11:58:39'
        ]);
        Permission::create([
            'id' => '947',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bet.bet-buangan',
            'description' => 'Can Access Bet Buangan',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:58:39',
            'updated_at' => '2021-09-16 11:58:39'
        ]);
        Permission::create([
            'id' => '948',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bet.buangan-terpasang',
            'description' => 'Can Access Bet Buangan Terpasang',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:58:39',
            'updated_at' => '2021-09-16 11:58:39'
        ]);
        Permission::create([
            'id' => '949',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.members.win_lose_togel',
            'description' => 'Can Access List Bet',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:58:39',
            'updated_at' => '2021-09-16 11:58:39'
        ]);
        Permission::create([
            'id' => '950',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.cms.list',
            'description' => 'Can Access List Bet',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:58:39',
            'updated_at' => '2021-09-16 11:58:39'
        ]);
        Permission::create([
            'id' => '951',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.bet.bets-table',
            'description' => 'Can Access Bets Table',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:58:39',
            'updated_at' => '2021-09-16 11:58:39'
        ]);
        Permission::create([
            'id' => '952',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.keluaran.scan',
            'description' => 'Can Access Scan Keluaran',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:58:39',
            'updated_at' => '2021-09-16 11:58:39'
        ]);
        Permission::create([
            'id' => '953',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.keluaran.submit',
            'description' => 'Can Access Submit Keluaran',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:58:39',
            'updated_at' => '2021-09-16 11:58:39'
        ]);
        Permission::create([
            'id' => '954',
            'type' => 'user',
            'guard_name' => 'web',
            'name' => 'user.access.keluaran.analisa',
            'description' => 'Can Access Analisa Keluaran',
            'parent_id' => NULL,'sort' => '1',
            'created_at' => '2021-09-16 11:58:39',
            'updated_at' => '2021-09-16 11:58:39'
        ]);        
        

        

        \DB::table('role_has_permissions')->insert([
            'permission_id' => '950',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '949',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '943',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '944',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '945',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '946',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '947',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '948',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '1',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '3',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '4',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '5',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '6',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '7',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '17',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '28',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '29',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '30',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '31',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '32',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '33',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '34',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '35',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '36',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '37',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '38',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '39',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '40',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '41',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '42',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '43',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '44',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '45',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '46',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '47',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '48',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '49',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '50',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '52',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '53',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '54',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '56',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '57',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '58',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '59',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '60',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '61',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '62',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '63',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '64',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '65',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '66',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '67',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '68',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '69',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '70',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '71',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '72',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '73',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '74',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '75',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '76',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '77',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '78',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '79',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '80',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '81',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '82',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '83',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '84',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '85',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '86',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '87',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '88',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '89',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '907',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '908',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '909',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '910',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '911',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '912',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '913',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '914',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '915',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '916',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '917',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '918',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '919',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '920',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '921',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '922',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '923',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '924',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '925',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '926',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '927',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '928',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '929',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '930',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '931',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '932',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '933',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '934',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '935',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '936',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '937',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '938',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '939',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '940',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '941',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '942',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '951',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '952',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '953',
            'role_id' => '2'
        ]);
        \DB::table('role_has_permissions')->insert([
            'permission_id' => '954',
            'role_id' => '2'
        ]);

        \DB::table('model_has_roles')->insert([
            'role_id' => '2',
            'model_type' => 'App\\Domains\\Auth\\Models\\User',
            'model_id' => '1'
        ]);
        

        $this->enableForeignKeys();
    }
}
