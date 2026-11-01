<?php

namespace App\Policies;

use App\Enum\RoleEnum;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): Response
    {
        if(
            $user->role === RoleEnum::ADMIN ||
            $ticket->user_id === $user->id ||
            $ticket->assigned_to === $user->id
        ){
            return Response::allow();
        }
        //note: i don't know why but i like to send all of it as 404 instead of 403
        // return Response::denyAsNotFound()
        return Response::denyWithStatus(404);
        //how do i make it my own status view design? dito ba talaga yun? or baka meron sa inertia?

    }

    /**
     * Determine whether the user can create models.
     */
    public function edit(User $user, Ticket $ticket): Response
    {
        if ($this->canManage($user, $ticket)) {
            return Response::allow();
        }
        return Response::denyWithStatus(404);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): Response
    {
        if ($this->canManage($user, $ticket)) {
            return Response::allow();
        }

        return Response::denyWithStatus(404);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): Response
    {
        if ($this->canManage($user, $ticket)) {
            return Response::allow();
        }


        return Response::denyWithStatus(404);
    }

    private function canManage(User $user, Ticket $ticket): bool
    {
        return $user->role !== RoleEnum::ADMIN
            && ($ticket->user_id === $user->id || $ticket->assigned_to === $user->id);
    }

    public function accept(User $user): Response {
            
            if($user->role == RoleEnum::ADMIN){
                return Response::allow();
            }
            return Response::denyWithStatus(404);
          
    }


    //why does when i created this polic in ticket attachment policy it is not reaching it? dahil ba pinapasa ko yung model?
    //pag pinasa ko yung $ticket yun ay sa ticket model ngayon naka associate na policy sa model na yun ay eto kaya dito rin sya hahanap na policy, okay gets HAHAHAH
    public function upload(User $user, Ticket $ticket): Response
    {
        
        if(
            $user->role === RoleEnum::MAINTENANCE && $ticket->assignedTo->is($user)
        ){
            return Response::allow();
        }
       
        return Response::denyWithStatus(404);
    }

  
}
