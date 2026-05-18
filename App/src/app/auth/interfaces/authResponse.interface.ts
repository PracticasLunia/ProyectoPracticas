import { User } from "./user.interface";

export interface  AuthResponse{
  user:             any
  token:            string;
  message:          string;
}
