import type { Metadata } from "next";
import { Quotes } from "@/app/components/quotes/Quotes";

export default function IndexPage() {
  return <Quotes />;
}

export const metadata: Metadata = {
  title: "Simpsons Quotes",
};
