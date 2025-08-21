import { Head, Link, usePage } from '@inertiajs/react';
import Dashboard from './dashboard';

export default function Welcome() {

    return (
        <>
            <Head title="Welcome">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div>Hello Developer!</div>
            <div>
            <Link href="orders">Order report</Link>
            </div>

            <div>
            <Link href="orderItems">OrderItems</Link>
            </div>



        </>
    );
}
