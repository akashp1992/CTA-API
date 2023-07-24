<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page = new \App\Models\Page();

        $page->truncate();
        $page->create([
            'organization_id' => 1,
            'slug'            => strtoupper(substr(md5(uniqid(rand(), true)), 0, 5)),
            'title'           => 'Terms & Conditions',
            'content'         => '<p>WEBSITE TERMS OF USE
                                    <br/>
                                    <br/>
                                    The Diet Bite website i.e. https://dietbiteq8.com/ (&ldquo;Website&rdquo;) is owned, hosted and maintained by
                                    Diet Bite. (&ldquo;Diet Bite/Us/We/Our&rdquo;) having its registered office at Kuwait. The Website provides its users (User(s)/You/Your)
                                    unique diet programs and an interactive platform.
                                    The following terms and conditions and any amendment or modification made thereto, govern the use of this Website and
                                    any content made available from or through this Website.
                                    <br/>
                                    <br/>
                                    By accessing this Website, the User warrants that the User has fully read and understood these
                                    T&amp;C and agrees to be legally bound by these terms and acknowledges unconditional acceptance
                                    without limitation or qualification of these T&amp;C. We may change these terms at any time
                                    without any prior notice in writing or otherwise to the User, by posting changes on the Website.
                                    The User may review these terms regularly to ensure that the User is aware of any changes made by us.
                                    The continued use of Our Website by the User, after changes are posted means that the User agrees to be legally
                                    bound by these terms as updated and/or amended. In the case of any violation of these T&amp;C or any additional
                                    terms posted on Website, We reserve the right to seek all remedies available in law and in equity for such violations.',
            'a_title'         => 'البنود و الظروف',
            'a_content'       => 'محتوى',
            'is_active'       => 1,
        ]);
    }
}
