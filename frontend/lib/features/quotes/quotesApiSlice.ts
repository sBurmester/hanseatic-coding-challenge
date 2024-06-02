import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";
import { RootState } from "@/app/store";

interface Quote {
  id: number;
  quote: string;
  author: string;
}

interface QuotesApiResponse {
  quotes: Quote[];
}

export const quotesApiSlice = createApi({
  baseQuery: fetchBaseQuery({
    baseUrl: "https://localhost:8000/api/quote",
    prepareHeaders: (headers: Headers, { getState }) => {
      const token = (getState() as RootState).auth.token;

      if (token) {
        headers.set("Authorization", `Bearer ${token}`);
      }

      return headers;
    },
  }),
  reducerPath: "quotesApi",
  // Tag types are used for caching and invalidation.
  tagTypes: ["Quotes"],
  endpoints: (build) => ({
    getQuotes: build.query<QuotesApiResponse, void>({
      query: () => "",
    }),
  }),
});

export const { useGetQuotesQuery } = quotesApiSlice;
