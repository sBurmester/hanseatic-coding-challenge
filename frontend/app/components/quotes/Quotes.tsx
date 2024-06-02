"use client";
import { useGetQuotesQuery } from "@/lib/features/quotes/quotesApiSlice";
import styles from "./Quotes.module.css";

export const Quotes = () => {
  const { data, isError, isLoading, isSuccess } = useGetQuotesQuery();

  if (isError) {
    return (
      <div>
        <h1>There was an error!!!</h1>
      </div>
    );
  }

  if (isLoading) {
    return (
      <div>
        <h1>Loading...</h1>
      </div>
    );
  }

  if (isSuccess) {
    return (
      <div className={styles.container}>
        {data.quotes.map(({ quote, id }) => (
          <blockquote key={id}>&ldquo;{quote}&rdquo;</blockquote>
        ))}
      </div>
    );
  }

  return null;
};
