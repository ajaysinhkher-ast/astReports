import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Order() {

  const { props } = usePage();
  const orderUrl = props.orderUrl as string;

  return (
    <>
      This is a order page
      <Link href="/"> Back</Link>
    </>
  );
}
