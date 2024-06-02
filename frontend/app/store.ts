import { configureStore } from "@reduxjs/toolkit";
import { api } from "./services/auth";
import { authSlice } from "@/lib/features/auth/authSlice";
import { quotesApiSlice } from "@/lib/features/quotes/quotesApiSlice";

export const store = configureStore({
  reducer: {
    [api.reducerPath]: api.reducer,
    [authSlice.reducerPath]: authSlice.reducer,
    [quotesApiSlice.reducerPath]: quotesApiSlice.reducer,
  },
  middleware: (getDefaultMiddleware) =>
    getDefaultMiddleware().concat(api.middleware, quotesApiSlice.middleware),
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;
export type StoreType = typeof store;
