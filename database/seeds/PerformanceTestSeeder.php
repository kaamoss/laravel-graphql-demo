<?php

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Seeder;

class PerformanceTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(EntityManagerInterface $entityManager)
    {
        $defaultAccount = entity(\App\Entities\Account::class)->create(['title'=>'Platform Defaults']);
        $defaultUser = entity(\App\Entities\User::class)->create(['account'=>$defaultAccount,'email'=>'admin@god.com']);
        $defaultMember = entity(\App\Entities\Membership::class)->create(['account'=>$defaultAccount, 'user'=>$defaultUser]);

        $numRegsAccounts = 6;
        $chunks = $this->getChunks($numRegsAccounts, 3);
        foreach($chunks as $chunkSize) {
            print ':Regs Accounts Chunk x:';
            for($i=0; $i<$chunkSize; $i++) {
                $resultAccount = entity(\App\Entities\Account::class)->create([]);
                $resultUsers = entity(\App\Entities\User::class,300)->make(['account'=>$resultAccount]);

                foreach($resultUsers as $resultUser) {
                    $entityManager->persist($resultUser);
                    $resultMembership = entity(\App\Entities\Membership::class)->make(['account'=>$resultAccount, 'user'=>$resultUser]);
                    $entityManager->persist($resultMembership);
                }

            }
            $entityManager->flush();
        }

        $numParentChildrenAccounts = 5;
        $chunks = $this->getChunks($numParentChildrenAccounts, 1);
        foreach($chunks as $chunkSize) {
            print ':Parent Child Chunk x:';
            for ($i = 0; $i < $chunkSize; $i++) {
                $parentAccount = entity(\App\Entities\Account::class)->create(['isParent' => true]);
                $parentUsers = entity(\App\Entities\User::class, 250)->make(['account' => $parentAccount]);
                foreach ($parentUsers as $parentUser) {
                    $entityManager->persist($parentUser);
                    $resultMembership = entity(\App\Entities\Membership::class)->make(['account' => $parentAccount, 'user' => $parentUser]);
                    $entityManager->persist($resultMembership);
                }
                $entityManager->flush();
                unset($parentUsers);
                print ':Parent Users committed:';

                $numChildren = rand(3, 10);
                for ($j = 0; $j < $numChildren; $j++) {
                    $childAccount = entity(\App\Entities\Account::class)->create(['parentAccount' => $parentAccount]);
                    print ':Child Account committed:';
                    $childUsers = entity(\App\Entities\User::class, 200)->make(['account' => $childAccount]);
                    foreach ($childUsers as $childUser) {
                        $entityManager->persist($childUser);
                        $resultMembership = entity(\App\Entities\Membership::class)->make(['account' => $childAccount, 'user' => $childUser]);
                        $entityManager->persist($resultMembership);
                    }

                }
                $entityManager->flush();
                unset($childUsers);
                print ':Child Users committed:';

            }
        }
        //create one big ass parent account with like 500 child accounts

    }

    public function getChunks(int $totalNum=100, int $perChunk=10): array {
        $chunks = [];
        $currentChunk = 1;
        while($perChunk*($currentChunk-1) <= $totalNum) {
            $numForChunk = $perChunk;
            if(($perChunk*($currentChunk-1))+$perChunk > $totalNum) {
                $numForChunk = $totalNum - ($perChunk*($currentChunk-1));
            }
            if($numForChunk > 0) {
                $chunks[] = $numForChunk;
            }
            $currentChunk++;
        }
        return $chunks;
    }
}
